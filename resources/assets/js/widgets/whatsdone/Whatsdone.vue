<template src="./Whatsdone.html"></template>

<style src="./Whatsdone.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return $.extend({}, this.$options._defaults, {
            url: "/api/whatsdone",
        });
	}

}

</script>
