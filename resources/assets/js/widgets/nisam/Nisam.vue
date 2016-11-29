<template src="./Nisam.html"></template>

<style src="./Nisam.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: "/api/nisam",
            response: {
                data: null,
                error: null
            }
        };
    }
}

</script>
