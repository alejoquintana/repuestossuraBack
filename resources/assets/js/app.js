require('intersection-observer');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
window.vue = Vue;
window.Vue = Vue;

var VueResource = require('vue-resource');
Vue.use(VueResource);

// Vue.http.interceptors.push(function (request, next) {
//     request.headers['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
//     next();
// });
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/* import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue); */

import VueMq from 'vue-mq'

Vue.component('fade-loader', require('vue-spinner/src/FadeLoader.vue').default);


// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import swal from 'sweetalert';
window.swal = swal;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});







Vue.use(VueMq, {
    breakpoints: {
        sm: 600,
        md: 990,
        lg: Infinity,
    }
});

String.prototype.ucfirst = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

import {store} from './store/store.js'
import { mapActions } from 'vuex'
import filters from  './filters.js';

import {
    directive as onClickOutside
} from 'vue-on-click-outside'
Vue.directive('on-click-outside', onClickOutside);



import VueAwesomeSwiper from 'vue-awesome-swiper'


Vue.use(VueAwesomeSwiper, /* { default global options } */ );


import { VLazyImagePlugin } from "v-lazy-image";

Vue.use(VLazyImagePlugin);

import myApp from './components/App.vue';
Vue.component('my-app', myApp);

import Routes from './routes.js';
/* 
window.csrf = $('meta[name="csrf-token"]').attr('content');
Vue.http.headers.common['X-CSRF-TOKEN'] = window.csrf;

 */
/* 


window.csrf = document.getElementById('csrf-token').getAttribute('content');
Vue.http.headers.common['X-CSRF-TOKEN'] = window.csrf; */

import Icon from 'laravel-mix-vue-svgicon/IconComponent.vue';
Vue.component( 'icon', Icon );


const app = new Vue({
    router: Routes,
    el: '#app',
    store,
    methods : {
        ...mapActions({
            fetchCategories : 'fetchCategories',
            fetchUser : 'fetchUser',
            fetchConfig : 'fetchConfig',
            fetchStates : 'fetchStates',
            fetchMeta:'fetchMeta'
        }),
    },
    created()
    { 
        this.fetchCategories();
        this.fetchUser();
        this.fetchConfig();
        this.fetchStates();
        this.fetchMeta();
    },  
    mounted(){
        window.csrf = document.getElementById('csrf-token').getAttribute('content');
        Vue.http.headers.common['X-CSRF-TOKEN'] = window.csrf;
   
    }  
});



