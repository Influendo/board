<template src="./Logo.html"></template>

<style src="./Logo.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: null,
            response: {
                data: null,
                error: null
            }
        };
    },

    mounted() {
        $(this.$el)
            .addClass("success");
    },

    methods: {
        request(options) {
            if (typeof (options || {}).success === "function") options.success();
            if (typeof (options || {}).complete === "function") options.complete();
        }
    }
}

</script>
