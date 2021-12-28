require('./bootstrap');

import Vue from 'vue'
import App from '../views/App.vue'
import router from './routes'

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.config.productionTip = false

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')

