<template src="./Dilbert.html"></template>

<style src="./Dilbert.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: "/api/dilbert",
            response: {
                data: null,
                error: null
            },
        };
    }

}

</script>
