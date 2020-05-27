<template>
    <div>
        <div v-show="alert" class="fixed left-0 top-0 w-full bg-white shadow-xl z-50">
            <div class="flex items-center justify-center p-3">
                <div class="w-20 mr-4">
                    <img :src="product.image" :alt="product.code" class="max-w-20">
                </div>
                <div class="mb-1 text-left">
                    <h4 class="text-primary mb-0 leading-none">{{ product.code }}</h4>
                    <p class="text-xs text-gray-500 leading-none">{{ product.name }}</p>
                    <p class="text-xs"><span class="font-semibold">Qty: </span>{{ product.quantity }} <span class="font-semibold">Price: </span>{{ product.price }}</p>
                </div>
            </div>

            <div class="bg-primary text-gray-800 text-center p-3" v-text="dropdown_message"></div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                alert: false,
                dropdown_message: '',
                product: {},
            }
        },
        methods: {
            showAlert(data) {
                this.alert = true;
                this.product = data.product;

                setTimeout(() => {
                    this.alert = false;
                }, 2000)
            }
        },
        mounted() {
            var self = this;

            Event.$on('product-added', function (data) {
                self.dropdown_message = 'Has been added to your basket';
                self.showAlert(data);
            });

            Event.$on('product-updated', function (data) {
                if (data.product) {
                    self.dropdown_message = 'Has been updated';
                    self.showAlert(data);
                }
            });
        }
    }
</script>
