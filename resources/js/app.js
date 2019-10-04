window.Vue = require('vue');

Vue.component('dropdown', require('./modules/Dropdown.vue').default);

const app = new Vue({
    el: '#app',
});
