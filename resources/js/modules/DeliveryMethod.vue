<template>
    <div class="xl:flex items-center relative mb-3">
        <label for="shipping" class="w-1/2">Shipping</label>

        <select id="shipping" name="shipping" autocomplete="off" v-model="delivery_id"
                @change="deliveryUpdated()">
            <option v-for="delivery in deliveries" :value="delivery.id">
                {{ delivery.title }} - {{ delivery.price === 0 ? 'FREE' : delivery.price.toFixed(2) }}
            </option>
        </select>
        <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 xl:pt-0 text-gray-700">
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
            small_order_threshold: {},
            goods_total: {},
        },
        data() {
            return {
                delivery_id: null,
                deliveries: [],
            }
        },
        methods: {
            deliveryUpdated() {
                Event.$emit('basket-updating', true);

                axios.get('/basket/summary/' + this.delivery_id).then(response => {
                    Event.$emit('delivery-updated', response.data);
                    Event.$emit('basket-updating', false);
                }).catch(error => {
                    Vue.swal({
                        title: 'Error',
                        text: 'Unable to update order summary',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            }
        },
        mounted() {
            this.delivery_id = this.old_delivery_method;

            this.delivery_methods.forEach(delivery => {
                let cost = parseFloat(this.goods_total) > this.small_order_threshold ? delivery.price_low : delivery.price;

                this.deliveries.push({
                    id: delivery.id,
                    code: delivery.code,
                    title: delivery.title,
                    price: cost,
                });
            });
        }
    }
</script>
