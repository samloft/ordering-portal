window.Vue = require('vue');
window.axios = require('axios');

import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

Vue.component('dropdown', require('./modules/Dropdown.vue').default);
Vue.component('order-upload', require('./modules/OrderUpload.vue').default);
Vue.component('expandable-image', require('./modules/ExpandableImage.vue').default);
Vue.component('date-picker', require('./modules/DatePicker.vue').default);
Vue.component('basket-dropdown', require('./modules/BasketDropdown.vue').default);
Vue.component('quick-buy', require('./modules/QuickBuy.vue').default);
Vue.component('add-basket', require('./modules/AddBasket.vue').default);
Vue.component('basket-summary', require('./modules/BasketSummary.vue').default);

window.Event = new Vue();

window.App = new Vue({
    el: '#app',
    mounted() {
        const viewportMeta = document.createElement('meta');
        viewportMeta.name = 'viewport';
        viewportMeta.content = 'width=device-width, initial-scale=1';
        document.head.appendChild(viewportMeta);
    },
    methods: {
        addProductToBasket: function (product, quantity) {
            return axios.post('/basket/add-product', {
                product: product,
                quantity: quantity
            })
                .then(function (response) {
                    if (response.data.message) {
                        Vue.swal('Warning', response.data.message, 'warning');
                    }

                    Event.$emit('product-added', response.data);

                    return true;
                })
                .catch(function (error) {
                    if (error.response) {
                        Vue.swal('Error', error.response.data.message, 'error');
                    }

                    return false;
                })
        },
        // basketSummary: function () {
        //     return axios.get('/basket/summary')
        //         .then(function (response) {
        //             if (response) {
        //                 self.basketValue = response.data.summary.goods_total;
        //                 self.basketItems = response.data.line_count;
        //             }
        //         });
        // }
    }
});
