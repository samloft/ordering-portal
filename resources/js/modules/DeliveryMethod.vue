<template>
    <div class="flex items-center relative mb-3">
        <label for="shipping" class="w-1/2">Shipping</label>

        <select id="shipping" name="shipping" autocomplete="off" v-model="delivery_code"
                @change="deliveryUpdated()">
            <option v-for="delivery in deliveries" :value="delivery.code">
                {{ delivery.title }} - {{ delivery.price === 0 ? 'FREE' : delivery.price.toFixed(2) }}
            </option>
        </select>
        <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                 class="fill-current h-4 w-4">
                <path
                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
            </svg>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            delivery_methods: {},
            old_delivery_method: null,
            small_order: {},
            goods_total: {},
        },
        data() {
            return {
                delivery_code: '',
                deliveries: [],
            }
        },
        methods: {
            deliveryUpdated() {
                axios.get('/basket/summary/' + this.delivery_code).then(response => {
                    Event.$emit('delivery-updated', response.data);
                }).catch(error => {
                    Vue.swal('Error', 'Unable to update order summary', 'error');
                });
            }
        },
        mounted() {
            this.delivery_code = this.old_delivery_method;

            this.delivery_methods.forEach(delivery => {
                console.log(delivery);
                let cost = parseFloat(this.goods_total) > this.small_order.threshold ? delivery.price_low : delivery.price;

                this.deliveries.push({
                    code: delivery.code,
                    title: delivery.title,
                    price: cost,
                });
            });
        }
    }
</script>
