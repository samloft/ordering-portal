<template>
    <div>
        <table class="mb-3" v-show="(products.length > 0)">
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

            <tr v-for="product in items">
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
                <td><span class="badge badge-info">{{ product.uom.charAt(0).toUpperCase() + product.uom.substring(1).toLowerCase() }}</span></td>
                <td class="text-right">{{ product.unit_price }}</td>
                <td class="text-center">
                    <input name="line_qty" class="w-20 h-6 text-right" :value="product.quantity"
                           autocomplete="off">
                    <div class="leading-none text-primary">
                        <small id="basket_line__update" class="quantity-update">Update</small> <small
                        id="basket-line__remove" class="quantity-remove">Remove</small>
                    </div>
                </td>
                <td class="text-right">{{ product.price }}</td>
            </tr>
            </tbody>
        </table>

        <div class="flex justify-between">
            <div>
                <a href="">
                    <button class="button button-inverse">Continue Shopping</button>
                </a>
                <button class="button button-inverse" v-show="(products.length > 0)">Empty basket</button>
            </div>

            <button class="button button-primary" v-show="(products.length > 0)">Save Basket</button>
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
        methods: {},
        mounted() {
            this.items = this.products;

            Event.$on('product-added', data => {
                this.items = data.basket_details.lines;
            });
        }
    }
</script>
