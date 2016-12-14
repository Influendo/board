<template src="./Quote.html"></template>

<style src="./Quote.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: '/api/quote',
            response: {
                data: null,
                error: null
            },
        };
    },

    methods: {
        background(value) {
            if (this.response.data) {
                return 'background-image:url(' + this.response.data.contents.quotes[0].background + ')';
            }

            return '';
        }
    }

}

</script>
