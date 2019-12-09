<template>
    <div>
        <div class="flex justify-between">
            <div>Goods Total</div>
            <div>{{ goods_total }}</div>
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
        <div class="flex justify-between text-lg mb-2">
            <div>Order Total</div>
            <div>{{ total }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                goods_total: this.summary.goods_total,
                shipping: this.summary.shipping,
                sub_total: this.summary.sub_total,
                small_order_charge: this.summary.small_order_charge,
                vat: this.summary.vat,
                total: this.summary.total
            }
        },
        props: {
            summary: {},
        },
        methods: {
            updateSummary: function (data) {
                this.goods_total = data.basket_details.summary.goods_total;
                this.shipping = data.basket_details.summary.shipping;
                this.sub_total = data.basket_details.summary.sub_total;
                this.small_order_charge = data.basket_details.summary.small_order_charge;
                this.vat = data.basket_details.summary.vat;
                this.total = data.basket_details.summary.total;
            }
        },
        mounted() {
            Event.$on('product-added', data => {
                this.updateSummary(data);
            });
        }
    }
</script>
