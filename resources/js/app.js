window.Vue = require('vue');
window.axios = require('axios');

import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.all.js';

require('es6-promise').polyfill();

Vue.use(VueSweetalert2);

Vue.component('dropdown', require('./modules/Dropdown.vue').default);
Vue.component('order-upload', require('./modules/OrderUpload.vue').default);
Vue.component('expandable-image', require('./modules/ExpandableImage.vue').default);
Vue.component('date-picker', require('./modules/DatePicker.vue').default);
Vue.component('basket-dropdown', require('./modules/BasketDropdown.vue').default);
Vue.component('quick-buy', require('./modules/QuickBuy.vue').default);
Vue.component('add-basket', require('./modules/AddBasket.vue').default);
Vue.component('basket-summary', require('./modules/BasketSummary.vue').default);
Vue.component('basket-table', require('./modules/BasketTable.vue').default);
Vue.component('customer-switch', require('./modules/CustomerSwitch.vue').default);
Vue.component('product-categories', require('./modules/ProductCategories.vue').default);
Vue.component('account-address', require('./modules/AccountAddress.vue').default);
Vue.component('order-invoice', require('./modules/OrderInvoice.vue').default);
Vue.component('delivery-method', require('./modules/DeliveryMethod.vue').default);
Vue.component('checkout', require('./modules/Checkout.vue').default);
Vue.component('submit-button', require('./modules/Button.vue').default);
Vue.component('product-data', require('./modules/ProductData.vue').default);
Vue.component('small-order-notice', require('./modules/SmallOrderNotice.vue').default);
Vue.component('fade-transition', require('./modules/FadeTransition.vue').default);
Vue.component('modal', require('./modules/Modal.vue').default);
Vue.component('mobile-menu', require('./modules/MobileMenu.vue').default);
Vue.component('mobile-alerts', require('./modules/MobileAlerts.vue').default);

window.Event = new Vue();

window.App = new Vue({
    el: '#app',
    methods: {
        addProductToBasket: function (product, quantity, update = false) {
            return axios.post('/basket/add-product', {
                product: product,
                quantity: quantity,
                update: update,
            })
                .then(function (response) {
                    if (response.data.message) {
                        Vue.swal('Warning', response.data.message, 'warning');
                    }

                    if (update) {
                        Event.$emit('product-updated', response.data);
                    } else {
                        Event.$emit('product-added', response.data);
                    }

                    return true;
                })
                .catch(function (error) {
                    if (error.response) {
                        Vue.swal('Error', error.response.data.message, 'error');
                    }

                    return false;
                })
        },
        copyToClipboard: function (id) {
            var range = document.createRange();

            range.selectNode(document.getElementById(id));
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand("copy");
            window.getSelection().removeAllRanges();
        }
    }
});
