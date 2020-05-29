require('./bootstrap');

import router from './router';
import VueRouter from "vue-router";
import Vue from 'vue'
import JsonCSV from 'vue-json-csv'

Vue.component('downloadCsv', JsonCSV)
Vue.use(VueRouter);

new Vue({
    el: '#app',
    router: router
});
