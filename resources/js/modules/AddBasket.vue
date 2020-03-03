<template>
    <div class="flex justify-between items-center mt-3">
        <span>Qty:</span>

        <input class="w-12" name="quantity"
               v-model="quantity">
        <button class="button button-primary"
                @click="submit()" v-text="buttonText" :disabled="addingProduct">
            Add To Basket
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
                this.buttonText = 'Adding Product';
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
