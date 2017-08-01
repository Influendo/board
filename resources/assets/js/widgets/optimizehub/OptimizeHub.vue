<template src="./OptimizeHub.html"></template>

<style src="./OptimizeHub.scss" lang="sass"></style>

<script>

export default {

    extends: Vue.options.components.widget,

    data() {
        return {
            url: "/api/optimizehub",
            interval: null,
            delay: 500,
            counter: "00:00:00"
        };
    }

}

</script>
