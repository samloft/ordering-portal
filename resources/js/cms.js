window.Vue = require('vue');
window.axios = require('axios');

import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

Vue.component('dropdown', require('./modules/Dropdown.vue').default);
Vue.component('site-users', require('./modules/SiteUsers.vue').default);

window.Event = new Vue();

window.App = new Vue({
    el: '#app',
    data: {
        isBurgerActive: false
    },
    methods: {
        toggleNav() {
            this.isBurgerActive = !this.isBurgerActive
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
