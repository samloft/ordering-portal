<template>
    <div>
        <div v-show="alert" class="md:hidden fixed left-0 top-0 w-full bg-white shadow-xl z-50">
            <div class="flex items-center p-3">
                <div class="mb-1">
                    <h4 class="text-primary mb-0">{{ product.code }}</h4>
                    <p class="text-xs font-light">{{ product.name }}</p>
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
