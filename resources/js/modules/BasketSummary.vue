<template>
    <div>
        <div class="flex justify-between">
            <div>Goods Total</div>
            <div>{{ goods_total }}</div>
        </div>
        <div v-if="promotion_discount.replace(/\D/g,'') > 0" class="flex justify-between text-primary font-medium">
            <div>Promotion Discount</div>
            <div>- {{ promotion_discount }}</div>
        </div>
        <div class="flex justify-between">
            <div>Shipping</div>
            <div>{{ shipping }}</div>
        </div>
        <div class="flex justify-between">
            <div>Sub Total</div>
            <div>{{ sub_total }}</div>
        </div>
        <div class="flex justify-between">
            <div>Small Order Charge*</div>
            <div>{{ small_order_charge }}</div>
        </div>
        <div class="flex justify-between">
            <div>VAT</div>
            <div>{{ vat }}</div>
        </div>
        <hr class="mt-2 mb-2">
        <div class="flex justify-between text-lg mb-2 font-semibold">
            <div>Order Total</div>
            <div>{{ total }}</div>
        </div>

        <div v-if="bulk_rate_savings" class="mb-2 text-primary font-medium">
            This total includes a saving of <span class="font-bold">{{ bulk_rate_savings }}</span> thanks to bulk rates.
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                goods_total: this.summary.goods_total,
                promotion_discount: this.summary.order_discount,
                shipping: this.summary.shipping.cost,
                sub_total: this.summary.sub_total,
                small_order_charge: this.summary.small_order_charge,
                vat: this.summary.vat,
                total: this.summary.total,
                bulk_rate_savings: this.summary.bulk_rate_savings
            }
        },
        props: {
            summary: {},
        },
        methods: {
            updateSummary: function (data) {
                this.goods_total = data.basket_details.summary.goods_total;
                this.promotion_discount = data.basket_details.summary.order_discount;
                this.shipping = data.basket_details.summary.shipping.cost;
                this.sub_total = data.basket_details.summary.sub_total;
                this.small_order_charge = data.basket_details.summary.small_order_charge;
                this.vat = data.basket_details.summary.vat;
                this.total = data.basket_details.summary.total;
                this.bulk_rate_savings = data.basket_details.summary.bulk_rate_savings;
            }
        },
        mounted() {
            Event.$on('product-added', data => {
                this.updateSummary(data);
            });

            Event.$on('product-updated', data => {
                this.updateSummary(data);
            });

            Event.$on('delivery-updated', data => {
                this.updateSummary({basket_details: data});
            });
        }
    }
</script>
