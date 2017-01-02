<template src="./Uprobot.html"></template>

<style src="./Uprobot.scss" lang="sass"></style>

<script>

export default {

    extends: Vue.options.components.widget,

    data() {
        return {
            url: "/api/uptimerobot"
        };
    }
}

</script>
