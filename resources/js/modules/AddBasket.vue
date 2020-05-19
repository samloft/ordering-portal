<template>
    <div class="flex sm:justify-end md:justify-between items-center md:w-full">
        <span class="mr-1 md:mr-0">Qty:</span>

        <input class="mr-1 md:mr-0 w-12" name="quantity"
               v-model="quantity">
        <button class="button button-primary flex items-center"
                @click="submit()" :disabled="addingProduct">
            {{ buttonText }}
            <svg v-if="addingProduct" xmlns="http://www.w3.org/2000/svg"
                 width="15px" height="15px" viewBox="0 0 40 40" enable-background="new 0 0 40 40"
                 xml:space="preserve" class="ml-3">
                              <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
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
        </button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                quantity: this.product.order_multiples,
                buttonText: 'Add To Basket',
                addingProduct: false,
            }
        },
        props: {
            product: {},
        },
        methods: {
            submit() {
                this.buttonText = 'Adding...';
                this.addingProduct = true;

                App.addProductToBasket(this.product.code, this.quantity).then(result => {
                    if (result) {
                        this.quantity = this.product.order_multiples;
                    }

                    this.buttonText = 'Add To Basket';
                    this.addingProduct = false;
                });
            }
        }
    }
</script>
