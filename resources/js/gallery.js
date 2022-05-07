window.Vue = require("vue");

window.axios = require('axios');
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import Multiselect from "vue-multiselect";
Vue.use(Toaster, {
    timeout: 5000
});
import {
    BootstrapVue,
    IconsPlugin
} from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.component("multiselect", Multiselect);

Vue.component("gallery", require("./components/Gallery.vue").default);
const patients = new Vue({
    el: "#gallery",
    data: {},
    methods: {},
    mounted() {}
});
