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

window.Event = new Vue();

const app = new Vue({
    el: '#app',
    mounted () {
        const viewportMeta = document.createElement('meta');
        viewportMeta.name = 'viewport';
        viewportMeta.content = 'width=device-width, initial-scale=1';
        document.head.appendChild(viewportMeta);
    }
});
