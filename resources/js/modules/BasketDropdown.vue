<template>
    <div class="flex items-center">
        <div class="hidden lg:block mr-2">
            <div class="relative">
                <span v-if="basketItems > 0" class="badge-basket">{{ basketItems }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     class="w-10 h-10 icon icon-shopping-cart">
                    <path class="primary"
                          d="M7 4h14a1 1 0 0 1 .9 1.45l-4 8a1 1 0 0 1-.9.55H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"></path>
                    <path class="secondary"
                          d="M17.73 19a2 2 0 1 1-3.46 0H8.73a2 2 0 1 1-3.42-.08A3 3 0 0 1 5 13.17V4H3a1 1 0 1 1 0-2h3a1 1 0 0 1 1 1v10h11a1 1 0 0 1 0 2H6a1 1 0 0 0 0 2h12a1 1 0 0 1 0 2h-.27z"></path>
                </svg>
            </div>
        </div>
        <div class="hidden lg:block ml-2 text-left flex mr-5">
            <span class="text-sm font-thin">My Cart</span>
            <div class="font-light">
                <span v-if="! basketUpdating">{{ basketValue }}</span>

                <svg v-if="basketUpdating" xmlns="http://www.w3.org/2000/svg"
                     width="20px" height="20px" viewBox="0 0 40 40" enable-background="new 0 0 40 40"
                     xml:space="preserve" class="ml-3">
                    <path opacity="0.2" fill="#fff" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                                  s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                                  c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
                    <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                                  C22.32,8.481,24.301,9.057,26.013,10.047z">
                        <animateTransform attributeType="xml"
                                          attributeName="transform"
                                          type="rotate"
                                          from="0 20 20"
                                          to="360 20 20"
                                          dur="0.5s"
                                          repeatCount="indefinite"/>
                    </path>
                </svg>
            </div>
        </div>

        <div @mouseenter="mouseOver" @mouseleave="mouseOut" class="hidden md:block">
            <slot name="basket-button"/>

            <div class="absolute pt-4">
                <div v-show="dropdown" class="basket-dropdown">
                    <div v-if="dropdownLoading" class="p-6">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="50px" height="50px" viewBox="0 0 40 40" enable-background="new 0 0 40 40"
                             xml:space="preserve" class="mx-auto">
                            <path opacity="0.2" fill="#F9FAFB" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                                  s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                                  c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
                            <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                                  C22.32,8.481,24.301,9.057,26.013,10.047z">
                                <animateTransform attributeType="xml"
                                                  attributeName="transform"
                                                  type="rotate"
                                                  from="0 20 20"
                                                  to="360 20 20"
                                                  dur="0.5s"
                                                  repeatCount="indefinite"/>
                            </path>
                        </svg>
                    </div>

                    <div v-else class="basket-dropdown-summary">
                        <div v-for="line in products" class="basket-dropdown-content">
                            <div class="flex items-center">
                                <div class="w-20 mr-4 pl-2 flex">
                                    <img :src="line.image" :alt="line.product">
                                </div>

                                <div class="mb-1">
                                    <h4 class="text-primary text-sm m-0">{{ line.product }}</h4>
                                    <p class="text-xs m-0">{{ line.name }}</p>
                                    <p class="text-xs m-0">
                                        <span class="text-gray-400">Qty:</span> <span class="font-semibold">{{ line.quantity }}</span>
                                        <span class="text-gray-400">Price:</span> <span class="font-semibold">{{ line.price }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="basketItems" class="hidden md:block">
            <slot name="checkout-button"/>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dropdown: false,
                products: {},
                basketValue: '',
                basketUpdating: true,
                basketItems: 0,
                dropdownLoading: false,
            }
        },
        methods: {
            mouseOver: function () {
                this.dropdown = true;
            },

            mouseOut: function () {
                this.dropdown = false;
            },
            closeIfClickedOutside(event) {
                if (!event.target.closest('.basket-dropdown')) {
                    this.dropdown = false;

                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            },
            basketSummary: async function (data = false) {
                var self = this;

                if (data) {
                    this.basketValue = data.basket_details.summary.goods_total;
                    this.basketItems = data.basket_details.line_count;
                    this.products = data.basket_details.lines;
                } else {
                    this.dropdownLoading = true;

                    await axios.get('/basket/summary')
                        .then(function (response) {
                            if (response) {
                                self.basketValue = response.data.summary.goods_total;
                                self.basketItems = response.data.line_count;
                                self.products = response.data.lines;
                            }
                        });

                    this.dropdownLoading = false;
                }

                this.basketUpdating = false;
            }
        },
        watch: {
            dropdown(dropdown) {
                if (dropdown) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            }
        },
        mounted() {
            var self = this;

            Event.$on('product-added', function (data) {
                self.basketUpdating = true;

                self.basketSummary(data);
            });

            Event.$on('product-updated', function (data) {
                self.basketUpdating = true;

                self.basketSummary(data);
            });

            this.basketSummary();
        }
    }
</script>
