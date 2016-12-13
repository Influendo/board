<template src="./Dilbert.html"></template>

<style src="./Dilbert.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: '/api/dilbert',
            response: {
                data: null,
                error: null
            },
        };
    },

    methods: {
        formatDate(value) {
            return new Date(value).toLocaleString(navigator.language, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        }
    }

}

</script>
