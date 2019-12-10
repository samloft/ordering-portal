<template>
    <div>
        <table class="mb-5" v-if="(items.length > 0)">
            <thead>
            <tr>
                <th>Product</th>
                <th>Unit</th>
                <th class="text-right">Net Price</th>
                <th class="text-center">Quantity</th>
                <th class="text-right">Total Price</th>
            </tr>
            </thead>
            <tbody class="row-sm">

            <tr v-for="product in items" :class="(product.quantity > product.stock) ? 'bg-red-200' : ''">
                <td>
                    <div class="flex items-center">
                        <img class="h-10 mr-2" :src="product.image" :alt="product.name">
                        <h2 class="leading-none">
                            <a :href="'/products/view/' + product.product">
                                <span class="text-primary font-medium">{{ product.product }}</span>
                                <br>
                                <span class="text-xs">{{ product.name }}</span>
                            </a>
                        </h2>
                    </div>
                </td>
                <td><span class="badge badge-info">{{ product.uom.charAt(0).toUpperCase() + product.uom.substring(1).toLowerCase() }}</span>
                </td>
                <td class="text-right">{{ product.unit_price }}</td>
                <td class="text-center">
                    <input name="line_qty" class="w-20 h-6 text-right bg-gray-100" v-model="product.quantity"
                           autocomplete="off">
                    <div class="leading-none text-primary">
                        <small class="cursor-pointer hover:underline" @click="updateProduct(product.product, product.quantity)">Update</small>
                        <small class="cursor-pointer hover:underline" @click="removeProduct(product.product)">Remove</small>
                    </div>
                </td>
                <td class="text-right">{{ product.price }}</td>
            </tr>
            </tbody>
        </table>

        <div class="text-xs mb-5">Red product lines have a chance of going onto backorder.</div>

        <div v-if="items.length === 0" class="bg-white rounded shadow-md p-6 text-center mb-5 text-2xl font-thin">
            Your basket is currently empty.
        </div>

        <div class="flex justify-between">
            <div>
                <a href="/products">
                    <button class="button button-inverse">Continue Shopping</button>
                </a>
                <button class="button button-inverse" v-show="(items.length > 0)" @click="emptyBasket">Empty basket
                </button>
            </div>

            <button class="button button-primary" v-show="(items.length > 0)" @click="saveBasket">Save Basket</button>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                items: {}
            }
        },
        props: {
            products: {},
        },
        methods: {
            emptyBasket: function () {
                Vue.swal({
                    title: "Empty Basket?",
                    text: "Are you sure? This cannot be un-done.",
                    type: "warning",
                    showCancelButton: true,
                }).then((response) => {
                    if (response.value) {
                        location.href = '/basket/empty';
                    }
                });
            },
            saveBasket: function () {
                Vue.swal({
                    title: 'Add a reference for your saved basket',
                    input: 'text',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to enter a reference.'
                        }
                    }
                }).then((response) => {
                    if (response.value) {
                        axios.post('/saved-baskets/store', {
                            reference: response.value
                        }).then(function (response) {
                            Vue.swal('Success', 'Your saved basket has been created', 'success');
                        }).catch(function () {
                            Vue.swal('Error', 'Could not create saved basket, please try again', 'error');
                        });
                    }
                });
            },
            updateProduct: function(product, quantity) {
                // if (!Number.isInteger(quantity)) {
                //     return Vue.swal('Error', 'Quantity must be a number, please fix this error and try again.', 'error');
                // }

                axios.post('/basket/update-product', {
                    product: product,
                    qty: quantity
                }).then(function() {
                    window.location.reload();
                }).catch(function() {
                    Vue.swal('Error', 'Unable to update product, please try again', 'error');
                })
            },
            removeProduct: function(product) {
                axios.post('/basket/delete-product', {
                    product: product
                }).then(function() {
                    window.location.reload();
                }).catch(function() {
                    Vue.swal('Error', 'Could not remove that product, please try again', 'error');
                })
            }
        },
        mounted() {
            this.items = this.products;

            Event.$on('product-added', data => {
                this.items = data.basket_details.lines;

                this.$forceUpdate()
            });
        }
    }
</script>
