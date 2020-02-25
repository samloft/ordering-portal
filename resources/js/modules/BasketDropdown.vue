<template>
    <div class="flex items-center">
        <div class="mr-2">
            <div class="relative">
                <span v-if="basketItems > 0" class="badge-basket">{{ basketItems }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     class="w-10 icon icon-shopping-cart">
                    <path class="primary"
                          d="M7 4h14a1 1 0 0 1 .9 1.45l-4 8a1 1 0 0 1-.9.55H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"/>
                    <path class="secondary"
                          d="M17.73 19a2 2 0 1 1-3.46 0H8.73a2 2 0 1 1-3.42-.08A3 3 0 0 1 5 13.17V4H3a1 1 0 1 1 0-2h3a1 1 0 0 1 1 1v10h11a1 1 0 0 1 0 2H6a1 1 0 0 0 0 2h12a1 1 0 0 1 0 2h-.27z"/>
                </svg>
            </div>
        </div>
        <div class="md:block ml-2 text-left flex mr-5">
            <span class="text-sm font-thin">My Cart</span>
            <div class="font-light">{{ basketValue }}</div>
        </div>

        <div @mouseenter="mouseOver" @mouseleave="mouseOut">
            <slot name="basket_button"/>

            <div class="absolute pt-4">
                <div v-show="dropdown" class="basket-dropdown">
                    <div class="basket-dropdown-summary">
                        <div v-for="line in products" class="basket-dropdown-content">
                            <div class="flex items-center">
                                <img :src="line.image" :alt="line.product">

                                <div class="mb-1">
                                    <h4 class="text-primary mb-2 mt-1">{{ line.product }}</h4>
                                    <p class="text-sm">{{ line.name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="alert" class="basket-dropdown">
                    <div class="basket-dropdown-content">
                        <div class="flex items-center">
                            <img :src="product.image" :alt="product.code">

                            <div class="mb-1">
                                <h4 class="text-primary mb-2">{{ product.code }}</h4>
                                <p class="text-sm">{{ product.name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="basket-dropdown-message" v-text="dropdown_message"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dropdown: false,
                alert: false,
                product: {},
                products: {},
                basketValue: 'Checking...',
                basketItems: 0,
                dropdown_message: '',
            }
        },
        methods: {
            mouseOver: function () {
                var self = this;
                this.alert = false;

                axios.get('/basket/dropdown')
                    .then(function (response) {
                        if (response.data.lines) {
                            self.dropdown = !!response.data.lines.length > 0;

                            self.products = response.data.lines;
                        }
                    });
            },

            mouseOut: function () {
                this.dropdown = false;
            },
            dropdownBasket: function (data) {
                this.dropdown = false;
                this.alert = true;
                this.product = data.product;

                setTimeout(() => {
                    this.alert = false;
                }, 2000)
            },
            basketSummary: function () {
                var self = this;

                axios.get('/basket/summary')
                    .then(function (response) {
                        if (response) {
                            self.basketValue = response.data.summary.goods_total;
                            self.basketItems = response.data.line_count;
                        }
                    });
            }
        },
        mounted() {
            var self = this;

            Event.$on('product-added', data => {
                this.dropdown_message = 'Has been added to your basket';
                this.dropdownBasket(data);
                this.basketSummary();
            });

            Event.$on('product-updated', data => {
                if(data.product) {
                    this.dropdown_message = 'Has been updated';
                    this.dropdownBasket(data);
                }

                this.basketSummary();
            });

            this.basketSummary();
        }
    }
</script>
