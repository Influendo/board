<template src="./Logo.html"></template>

<style src="./Logo.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data () {
        return $.extend({}, this.$options._defaults, {
            url: null,
        });
    }
}

</script>
