//Vue.component('test',require('./components/test.vue').default)
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";
Vue.use(Toast, {
    transition: "Vue-Toastification__fade",
    maxToasts: 20,
    newestOnTop: true,
    position: "bottom-right",
});

Vue.component('theader',require('./components/theader.vue').default)
Vue.component('ttable',require('./components/ttable.vue').default)
Vue.component('tmodal',require('./components/t-modal.vue').default)

Vue.component('product-index', require('./components/product/product-index').default)
Vue.component('product-tr', require('./components/product/product-tr.vue').default)
Vue.component('product-create', require('./components/product/product-create-button').default)

Vue.component('invoice-index', require('./components/invoice/invoice-index').default)