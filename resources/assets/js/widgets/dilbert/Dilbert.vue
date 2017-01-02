<template src="./Dilbert.html"></template>

<style src="./Dilbert.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: '/api/dilbert'
        };
    },

    methods: {
        formatDate(value) {
            //return new Date(value).toLocaleString('en-GB', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

            let date = new Date(value);
            return ''
                + window.Locale.weekdays[date.getDay() ? date.getDay() - 1 : window.Locale.weekdays.length - 1]
                + ', '
                + date.getDate()
                + ' '
                + window.Locale.months[date.getMonth()]
                + ' '
                + date.getFullYear();
        }
    }

}

</script>
