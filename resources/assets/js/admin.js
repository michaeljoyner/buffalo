window.swal = require('sweetalert');

var Vue = require('vue');

Vue.use(require('vue-resource'));

if(document.querySelector('#x-token')) {
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#x-token').getAttribute('content');
}

Vue.component('toggle-button', require('./components/Togglebutton.vue'));
Vue.component('single-upload', require('./components/Singleupload.vue'));
Vue.component('toggle-switch', require('./components/Toggleswitch.vue'));
Vue.component('banner-slide', require('./components/Bannerslide.vue'));
Vue.component('sort-list', require('./components/Sortvue.vue'));
Vue.component('search-view', require('./components/Searchview.vue'));
Vue.component('stat-counter', require('./components/Statcounter.vue'));

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
        }
    }
});