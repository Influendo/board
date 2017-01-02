<template src="./Whatsdone.html"></template>

<style src="./Whatsdone.scss" lang="sass"></style>

<script>

export default {

    extends: Vue.options.components.widget,

    data() {
        return {
            url: "/api/whatsdone"
        };
    }

}

</script>
