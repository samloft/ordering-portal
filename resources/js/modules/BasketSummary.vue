<template>
    <div>
        <div class="flex justify-between">
            <div :class="basket_updating ? 'box-placeholder' : ''">Goods Total</div>
            <div :class="basket_updating ? 'box-placeholder' : ''">{{ goods_total }}</div>
        </div>
        <div v-if="promotion_discount.replace(/\D/g,'') > 0" class="flex justify-between text-primary font-medium">
            <div :class="basket_updating ? 'box-placeholder' : ''">Promotion Discount</div>
            <div :class="basket_updating ? 'box-placeholder' : ''">- {{ promotion_discount }}</div>
        </div>
        <div class="flex justify-between">
            <div :class="basket_updating ? 'box-placeholder' : ''">Shipping</div>
            <div :class="basket_updating ? 'box-placeholder' : ''">{{ shipping }}</div>
        </div>
        <div class="flex justify-between">
            <div :class="basket_updating ? 'box-placeholder' : ''">Sub Total</div>
            <div :class="basket_updating ? 'box-placeholder' : ''">{{ sub_total }}</div>
        </div>
        <div class="flex justify-between">
            <div :class="basket_updating ? 'box-placeholder' : ''">Small Order Charge*</div>
            <div :class="basket_updating ? 'box-placeholder' : ''">{{ small_order_charge }}</div>
        </div>
        <div class="flex justify-between">
            <div :class="basket_updating ? 'box-placeholder' : ''">VAT</div>
            <div :class="basket_updating ? 'box-placeholder' : ''">{{ vat }}</div>
        </div>
        <hr class="mt-2 mb-2">
        <div class="flex justify-between text-lg mb-2 font-semibold">
            <div :class="basket_updating ? 'box-placeholder' : ''">Order Total</div>
            <div :class="basket_updating ? 'box-placeholder' : ''">{{ total }}</div>
        </div>

        <div v-if="bulk_rate_savings" class="mb-2 text-primary font-medium" :class="basket_updating ? 'box-placeholder' : ''">
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
                bulk_rate_savings: this.summary.bulk_rate_savings,
                basket_updating: false,
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

            Event.$on('basket-updating', data => {
                this.basket_updating = data;
            });
        }
    }
</script>
