//i18n-setup.js
import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)


const months = {
    fr: {
        'fev': 'fevririer'
    }
}
export const i18n = new VueI18n({
    locale: 'fr', // set locale
    months // set locale messages
});