<template src="./EuroJackpot.html"></template>

<style src="./EuroJackpot.scss" lang="sass"></style>

<script>

export default {

    extends: Vue.options.components.widget,

    data() {
        return {
            url: '/api/eurojackpot'
        };
    },

    methods: {
        formatDate(value) {
            let date = new Date(value);

            return ''
                + window.Locale.weekdays[date.getDay() ? date.getDay() - 1 : window.Locale.weekdays.length - 1]
                + ', '
                + date.getDate()
                + ' '
                + window.Locale.months[date.getMonth()]
                + ' '
                + date.getFullYear();
        },

        formatTime(value) {
            let date = new Date(value);

            return ''
                + ('0' + date.getHours()).substr(-2)
                + ':'
                + ('0' + date.getMinutes()).substr(-2);
        }
    }

}

</script>
