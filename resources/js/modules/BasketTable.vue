<template>
    <div>
        <div v-if="potential_saving">
            <div class="alert alert-warning" role="alert">
                <div class="alert-body">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                        <path class="primary" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"></path>
                        <path class="secondary"
                              d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                    </svg>
                    <div class="w-full">
                        <div class="flex justify-between items-center">
                            <div class="alert-title">You have some savings, please review them below.</div>
                            <button @click="allSavings()"
                                    class="bg-gray-700 p-2 text-white font-light tracking-wider rounded-lg hover:opacity-75 text-xs">
                                Action all savings of <span v-text="potential_saving_total"/>
                            </button>
                        </div>

                        <div class="mt-4 text-gray-600">
                            <div v-for="product in items" v-if="product.potential_saving"
                                 class="flex justify-between items-center mb-2">
                                <div>{{ product.product }} - Add <span class="font-semibold">{{ product.next_bulk.qty_away }}</span>
                                    more for a saving of <span
                                        class="font-semibold">{{ product.next_bulk.saving }}</span></div>
                                <button
                                    @click="updateProduct(product.product, (product.next_bulk.qty_away + product.quantity))"
                                    class="bg-gray-700 p-1 text-white font-light tracking-wider rounded-lg hover:opacity-75 text-xs">
                                    Action saving
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5 table-container" v-if="(items.length > 0)">
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit</th>
                    <th class="text-right">Net Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Total Price</th>
                </tr>
                </thead>
                <tbody class="">

                <tr v-for="product in items" :class="(product.quantity > product.stock) ? 'bg-red-200' : ''">
                    <td>
                        <div class="flex items-center">
                            <img class="w-15 mr-3" :src="product.image" :alt="product.name">
                            <h2 class="leading-none">
                                <a :href="'/products/view/' + product.product">
                                    <span class="text-primary font-medium">{{ product.product }}</span>
                                    <br>
                                    <span class="text-xs font-thin text-gray-600">{{ product.name }}</span>
                                </a>
                            </h2>
                        </div>
                    </td>
                    <td><span class="badge badge-info">{{ product.uom.charAt(0).toUpperCase() + product.uom.substring(1).toLowerCase() }}</span>
                    </td>
                    <td class="text-right text-gray-500 text-sm">{{ product.net_price }}</td>
                    <td class="text-center">
                        <div class="flex flex-grow flex-col">
                            <input name="line_qty" class="w-24 h-6 text-right bg-gray-100" v-model="product.quantity"
                                   @keyup.enter="updateProduct(product.product, product.quantity)"
                                   autocomplete="off">
                            <div class="leading-none text-primary">
                                <small class="cursor-pointer hover:underline"
                                       @click="updateProduct(product.product, product.quantity)">Update</small>
                                <small class="cursor-pointer hover:underline"
                                       @click="removeProduct(product.product)">Remove</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-right text-sm">{{ product.price }}</td>
                </tr>
                </tbody>
            </table>
        </div>

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
                items: {},
                potential_saving: false,
                potential_saving_total: 0,
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
            updateProduct: function (product, quantity) {
                if (parseInt(quantity) === 0) {
                    return this.removeProduct(product);
                }

                App.addProductToBasket(product, quantity, true);
            },
            removeProduct: function (product) {
                axios.post('/basket/delete-product', {
                    product: product
                }).then(function () {
                    window.location.reload();
                }).catch(function () {
                    Vue.swal('Error', 'Could not remove that product, please try again', 'error');
                })
            },
            allSavings: function () {
                self = this;

                this.items.forEach(function (product) {
                    if (product.potential_saving) {
                        self.updateProduct(product.product, (product.next_bulk.qty_away + product.quantity))
                    }
                });
            }
        },
        mounted() {
            this.items = this.products.lines;
            this.potential_saving = this.products.potential_saving;
            this.potential_saving_total = this.products.potential_saving_total;

            Event.$on('product-added', data => {
                this.items = data.basket_details.lines;
                this.potential_saving = data.basket_details.potential_saving;
                this.potential_saving_total = data.basket_details.potential_saving_total;

                this.$forceUpdate()
            });

            Event.$on('product-updated', data => {
                this.items = data.basket_details.lines;
                this.potential_saving = data.basket_details.potential_saving;
                this.potential_saving_total = data.basket_details.potential_saving_total;

                this.$forceUpdate()
            });
        }
    }
</script>
