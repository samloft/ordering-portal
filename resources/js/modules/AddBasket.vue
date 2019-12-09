<template>
    <div class="flex justify-between items-center mt-3">
        <span>Qty:</span>

        <input class="w-12" name="quantity"
               v-model="quantity">
        <button class="button button-primary"
                @click="submit()">
            Add To Basket
        </button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                quantity: this.product.order_multiples
            }
        },
        props: {
            product: {},
        },
        methods: {
            submit() {
                App.addProductToBasket(this.product.code, this.quantity).then(result => {
                    if (result) {
                        this.quantity = this.product.order_multiples;
                    }
                });
            }
        }
    }
</script>
