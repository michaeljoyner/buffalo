try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}


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


Vue.component('modal', require('./components/Modal.vue'));
// Vue.component('toggle-button', require('./components/Togglebutton.vue'));
Vue.component('publish-button', require('./components/Publishbutton.vue'));
Vue.component('single-upload', require('./components/Singleupload.vue'));
Vue.component('toggle-switch', require('./components/Toggleswitch.vue'));
Vue.component('banner-slide', require('./components/Bannerslide.vue'));
Vue.component('sort-list', require('./components/Sortvue.vue'));
Vue.component('search-view', require('./components/Searchview.vue'));
Vue.component('stat-counter', require('./components/Statcounter.vue'));
// Vue.component('featured-images', require('./components/Featuredimage.vue'));
Vue.component('social-user', require('./components/Socialuser.vue'));
Vue.component('dropzone', require('./components/Dropzone.vue'));
Vue.component('gallery-show', require('./components/Galleryshow.vue'));
Vue.component('sharing-summary', require('./components/Sharingsummary.vue'));
Vue.component('category-mover', require('./components/Categorymover.vue'));
Vue.component('product-promoter', require('./components/Productpromoter.vue'));
Vue.component('new-until-switch', require('./components/Newuntilswitch.vue'));
Vue.component('type-ahead', require('./components/Typeahead.vue'));
Vue.component('factory-input', require('./components/Factoryinput.vue'));
Vue.component('customer-search', require('./components/Customersearch.vue'));
Vue.component('quote-app', require('./components/QuoteApp.vue'));
Vue.component('quote-item-add', require('./components/QuoteItemAdd.vue'));
Vue.component('quote-item', require('./components/QuoteItem.vue'));
Vue.component('delete-button', require('./components/DeleteButton.vue'));
Vue.component('supply-selector', require('./components/SupplySelector.vue'));
Vue.component('description-editor', require('./components/QuoteItemDescriptionEditor.vue'));
Vue.component('finalise-quote-button', require('./components/FinaliseQuoteButton.vue'));
Vue.component('search-quote-form', require('./components/QuoteSearchForm.vue'));
Vue.component('clone-quote-form', require('./components/CloneQuoteForm.vue'));


window.eventHub = new Vue();


new Vue({
    el:'#app',

    mounted() {
        eventHub.$on('error-alert', this.showErrorMessage);
        eventHub.$on('success-alert', this.showSuccessMessage);
    },

    methods: {
        showErrorMessage(message) {
            swal({
                icon: 'error',
                title: 'Oh no! An error!',
                text: message,
            });
        },

        showSuccessMessage({message, title = 'Success!'}) {
            swal({
                icon: 'success',
                title: title,
                text: message,
            });
        }
    }
});