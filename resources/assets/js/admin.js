window.swal = require('sweetalert');

var Vue = require('vue');

Vue.use(require('vue-resource'));

if(document.querySelector('#x-token')) {
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#x-token').getAttribute('content');
}

Vue.component('modal', require('./components/Modal.vue'));
Vue.component('toggle-button', require('./components/Togglebutton.vue'));
Vue.component('publish-button', require('./components/Publishbutton.vue'));
Vue.component('single-upload', require('./components/Singleupload.vue'));
Vue.component('toggle-switch', require('./components/Toggleswitch.vue'));
Vue.component('banner-slide', require('./components/Bannerslide.vue'));
Vue.component('sort-list', require('./components/Sortvue.vue'));
Vue.component('search-view', require('./components/Searchview.vue'));
Vue.component('stat-counter', require('./components/Statcounter.vue'));
Vue.component('featured-images', require('./components/Featuredimage.vue'));
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

Vue.http.interceptors.unshift(function(request, next) {
    next(function(response) {
        if(typeof response.headers['content-type'] != 'undefined') {
            response.headers['Content-Type'] = response.headers['content-type'];
        }
    });
});

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

        'image-added': function(image) {
            this.$broadcast('add-image', image);
        }
    }
});