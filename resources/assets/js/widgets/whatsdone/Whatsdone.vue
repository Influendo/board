<template src="./Whatsdone.html"></template>

<style src="./Whatsdone.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: "/api/whatsdone",
            response: {
                data: null,
                error: null
            }
        };
    }

}

</script>
