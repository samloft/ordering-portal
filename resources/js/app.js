window.Vue = require('vue');

Vue.component('dropdown', require('./modules/Dropdown.vue').default);
Vue.component('order-upload', require('./modules/OrderUpload.vue').default);

const app = new Vue({
    el: '#app',
});
