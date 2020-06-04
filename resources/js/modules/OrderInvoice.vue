<template>
    <div v-show="pdfFound" class="inline-block">
        <a :href="pdfUrl" class="btn-link d-none">
            <button class="button button-primary">Download Copy Invoice</button>
        </a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                pdfFound: false,
                pdfUrl: ''
            }
        },
        props: {
            order: null,
            customer_order: null
        },
        mounted() {
            var self = this;

            axios.get('/order-tracking/invoice/' + encodeURI(this.order) + '/' + encodeURI(this.customer_order))
            .then( function(response) {
                if (response.data.pdf_exists) {
                    self.pdfFound = true;
                    self.pdfUrl = '/order-tracking/invoice/' + encodeURI(self.order) + '/' + encodeURI(self.customer_order) + '/true'
                }
            });
        }
    }
</script>
