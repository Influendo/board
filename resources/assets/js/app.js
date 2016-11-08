
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Also load some app specific scripts
 */
// require('./layout');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('board',              require('./components/Board.vue'));
Vue.component('widgets-nisam',      require('./widgets/nisam/Nisam.vue'));
Vue.component('widgets-whats-done', require('./widgets/whats-done/WhatsDone.vue'));
Vue.component('widgets-uprobot',    require('./widgets/uprobot/UpRobot.vue'));
Vue.component('widgets-image-feed', require('./widgets/image-feed/ImageFeed.vue'));

const app = new Vue({
    el: '#app'
});
