require("./bootstrap");
import Vue from "vue";

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueI18n from 'vue-i18n'


Vue.use(VueI18n)
// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import "./style.css";
import "./assets/architect/main.css";
import store from './store';
import router from './router';
// import axios from './config/axios.js';
import {
    Form,
    HasError,
    AlertError
} from "vform";


window.Form = Form;
Vue.use(Toaster, {
    timeout: 1500
});

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);


Vue.component(
    "app",
    require("./App.vue").default
);
import PortalVue from 'portal-vue'
Vue.use(PortalVue)
// import { QuasarTiptapPlugin, RecommendedExtensions } from 'quasar-tiptap'

// Vue.use(QuasarTiptapPlugin, {
//     language: 'zh-hans',
//     spellcheck: true
// })
const app = new Vue({
    el: "#app",
    store,
    router,
    components: {

    },
});
