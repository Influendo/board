<template src="./Uprobot.html"></template>

<style src="./Uprobot.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: "/api/uptimerobot"
        };
    }
}

</script>
