<template src="./Uprobot.html"></template>

<style src="./Uprobot.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data () {
        return $.extend({}, this.$options._defaults, {
            url: "/api/uptimerobot",
        });
    }
}

</script>
