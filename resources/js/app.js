window.Vue = require('vue');

Vue.component('dropdown', require('./modules/Dropdown.vue').default);
Vue.component('order-upload', require('./modules/OrderUpload.vue').default);
Vue.component('expandable-image', require('./modules/ExpandableImage.vue').default);

const app = new Vue({
    el: '#app',
    mounted () {
        const viewportMeta = document.createElement('meta');
        viewportMeta.name = 'viewport';
        viewportMeta.content = 'width=device-width, initial-scale=1';
        document.head.appendChild(viewportMeta);
    }
});
