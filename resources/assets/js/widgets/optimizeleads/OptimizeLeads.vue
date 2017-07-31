<template src="./OptimizeLeads.html"></template>

<style src="./OptimizeLeads.scss" lang="sass"></style>

<script>

export default {

    extends: Vue.options.components.widget,

    data() {
        return {
            url: "/api/optimizeleads",
            interval: null,
            delay: 500,
            counter: "00:00:00"
        };
    },

    mounted() {
        console.log(this.response);
    }

}

</script>
