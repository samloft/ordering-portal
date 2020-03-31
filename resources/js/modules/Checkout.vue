<template>
    <div>
        <button @click="checkout()" type="submit" class="button button-primary">Place Order</button>

        <modal v-show="modal">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100">
                <svg class="h-12 w-12 text-green-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path d="M7 4h14a1 1 0 0 1 .9 1.45l-4 8a1 1 0 0 1-.9.55H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"
                          class="primary"></path>
                    <path
                        d="M17.73 19a2 2 0 1 1-3.46 0H8.73a2 2 0 1 1-3.42-.08A3 3 0 0 1 5 13.17V4H3a1 1 0 1 1 0-2h3a1 1 0 0 1 1 1v10h11a1 1 0 0 1 0 2H6a1 1 0 0 0 0 2h12a1 1 0 0 1 0 2h-.27z"
                        class="secondary"></path>
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Placing Order
                </h3>
                <div class="mt-2">
                    <p class="text-sm leading-5 text-gray-500">
                        We are processing your order, please wait.
                    </p>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                modal: false,
            }
        },
        methods: {
            checkout: function () {
                this.modal = true;
            }
        }
    }
</script>
