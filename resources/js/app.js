/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 require('./bootstrap');
 window.Vue = require('vue').default;
 import App from './App.vue';
 import VueAxios from 'vue-axios';
 import VueRouter from 'vue-router';
 import axios from 'axios';
 import { routes } from './routes';
 import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
 import 'bootstrap/dist/css/bootstrap.css'
 import 'bootstrap-vue/dist/bootstrap-vue.css'
 import 'bootstrap-vue/dist/bootstrap-vue-icons.min.css'



 /**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */
 Vue.use(VueRouter);
 Vue.use(VueAxios, axios);
 // Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(BootstrapVueIcons)
  
 const router = new VueRouter({
     mode: 'history',
     routes: routes
 });
  
 const app = new Vue({
     el: '#app',
     router: router,
     render: h => h(App),
 });
