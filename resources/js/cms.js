window.Vue = require('vue');
window.axios = require('axios');

import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

Vue.component('dropdown', require('./modules/Dropdown.vue').default);
Vue.component('admin-users', require('./modules/AdminUsers.vue').default);
Vue.component('site-users', require('./modules/SiteUsers.vue').default);
Vue.component('product-images', require('./modules/ProductImages.vue').default);
Vue.component('home-links', require('./modules/HomeLinks.vue').default);
Vue.component('customer-discounts', require('./modules/CustomerDiscounts.vue').default);
Vue.component('delivery-methods', require('./modules/DeliveryMethods.vue').default);
Vue.component('contacts', require('./modules/Contacts.vue').default);
Vue.component('maintenance', require('./modules/Maintenance.vue').default);
Vue.component('category-images', require('./modules/CategoryImages.vue').default);

window.Event = new Vue();

window.App = new Vue({
    el: '#app',
    data: {
        isBurgerActive: false
    },
    methods: {
        toggleNav() {
            this.isBurgerActive = !this.isBurgerActive
        },
        humanFileSize: function(bytes, si) {
            var thresh = si ? 1000 : 1024;
            if(Math.abs(bytes) < thresh) {
                return bytes + ' B';
            }
            var units = si
                ? ['kB','MB','GB','TB','PB','EB','ZB','YB']
                : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
            var u = -1;
            do {
                bytes /= thresh;
                ++u;
            } while(Math.abs(bytes) >= thresh && u < units.length - 1);
            return bytes.toFixed(1)+' '+units[u];
        }
    },
    mounted() {
        const viewportMeta = document.createElement('meta');
        viewportMeta.name = 'viewport';
        viewportMeta.content = 'width=device-width, initial-scale=1';
        document.head.appendChild(viewportMeta);
    }
});

Vue.directive('uppercase', {
    update(el) {
        el.value = el.value.toUpperCase()
    },
});
