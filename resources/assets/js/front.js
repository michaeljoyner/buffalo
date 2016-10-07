window.swal = require('sweetalert');

var Vue = require('vue');

Vue.use(require('vue-resource'));

if(document.querySelector('#x-token')) {
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#x-token').getAttribute('content');
}

Vue.component('carousel-slider', require('./components/Carousel.vue'));
Vue.component('contact-form', require('./components/Contactform.vue'));
Vue.component('cart-button', require('./components/Cartbutton.vue'));
Vue.component('cart-item', require('./components/Cartitem.vue'));
Vue.component('cart-app', require('./components/Cart.vue'));
Vue.component('cart-alert', require('./components/Cartalert.vue'));

window.Vue = Vue;

new Vue({
    el:'body',

    events: {
        'user-alert': function(message) {
            swal({
                type: message.type,
                title: message.title,
                text: message.text,
                showConfirmButton: message.confirm
            });
        },

        'item-added': function() {
            this.$broadcast('cart-item-added');
        }
    }
});

if(document.querySelector('#search-trigger')) {
    const trigger = document.querySelector('#search-trigger');
    const searchInput = document.querySelector('.search-input')
    trigger.addEventListener('change', (ev) => {if(trigger.checked) searchInput.focus() }, false);
}

if(document.querySelector('.menu-select')) {
    const select = document.querySelector('.menu-select');
    select.addEventListener('change', (ev) => window.location = ev.target.value, false);
}