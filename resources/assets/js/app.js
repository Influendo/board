
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


Vue.component('inactivity',                   require('./components/inactivity/Inactivity.vue'));
Vue.component('updater',                      require('./components/updater/Updater.vue'));
Vue.component('board',                        require('./components/board/Board.vue'));
Vue.component('osd',                          require('./components/osd/Osd.vue'));
Vue.component('slider',                       require('./components/slider/Slider.vue'));
Vue.component('background',                   require('./components/background/Background.vue'));
Vue.component('backdrop',                     require('./components/backdrop/Backdrop.vue'));
Vue.component('overlay',                      require('./components/overlay/Overlay.vue'));

window._widget = Vue.component('widget', require('./components/widget/Widget.vue'));
Vue.component('widget-logo',                  require('./widgets/logo/Logo.vue'));
Vue.component('widget-calendar',              require('./widgets/calendar/Calendar.vue'));
Vue.component('widget-dilbert',               require('./widgets/dilbert/Dilbert.vue'));
Vue.component('widget-weather',               require('./widgets/weather/Weather.vue'));
Vue.component('widget-nisam',                 require('./widgets/nisam/Nisam.vue'));
Vue.component('widget-whatsdone',             require('./widgets/whatsdone/Whatsdone.vue'));
Vue.component('widget-uprobot',               require('./widgets/uprobot/Uprobot.vue'));
Vue.component('widget-currency',              require('./widgets/currency/Currency.vue'));

const app = new Vue({
    el: '#app'
});
