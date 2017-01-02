<template src="./Logo.html"></template>

<style src="./Logo.scss" lang="sass"></style>

<script>

export default {

    extends: Vue.options.components.widget,

    mounted() {
        $(this.$el)
            .addClass("success");
    },

    methods: {
        request(options) {
            if (typeof (options || {}).success  === "function") options.success();
            if (typeof (options || {}).complete === "function") options.complete();
        }
    }
}

</script>
