window.swal = require('sweetalert');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import Vue from "vue";
window.Vue = Vue;



// Vue.component('carousel-slider', require('./components/Carousel.vue'));
// Vue.component('video-slide', require('./components/Videoslide.vue'));
// Vue.component('banner-slide', require('./components/Slide.vue'));
// Vue.component('contact-form', require('./components/Contactform.vue'));
// Vue.component('cart-button', require('./components/Cartbutton.vue'));
// Vue.component('cart-item', require('./components/Cartitem.vue'));
// Vue.component('cart-app', require('./components/Cart.vue'));
// Vue.component('cart-alert', require('./components/Cartalert.vue'));
Vue.component('stat-counter', require('./components/Statcounter.vue'));

window.eventHub = new Vue();

new Vue({
    el:'#app',

    // events: {
    //     'user-alert': function(message) {
    //         swal({
    //             type: message.type,
    //             title: message.title,
    //             text: message.text,
    //             showConfirmButton: message.confirm
    //         });
    //     },
    //
    //     'item-added': function() {
    //         this.$broadcast('cart-item-added');
    //     }
    // }
});

if(document.querySelector('#search-trigger')) {
    const trigger = document.querySelector('#search-trigger');
    const searchInput = document.querySelector('.search-input');
    trigger.addEventListener('change', (ev) => {if(trigger.checked) searchInput.focus() }, false);
}

if(document.querySelector('.menu-select')) {
    const select = document.querySelector('.menu-select');
    select.addEventListener('change', (ev) => window.location = ev.target.value, false);
}

document.body.addEventListener('keypress', (ev) => {
    if(ev.keyCode !== 47) {
        return;
    }
    const trigger = document.querySelector('#search-trigger');
    const searchInput = document.querySelector('.search-input');
    trigger.checked = !trigger.checked;
    if(trigger.checked) {
        searchInput.focus();
    }
    ev.preventDefault();
}, false);

window.addEventListener("load", (event) => document.body.classList.add('page-loaded'));
