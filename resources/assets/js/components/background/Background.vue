<template src="./Background.html"></template>

<style src="./Background.scss" lang="sass"></style>

<script>

export default {

    props: ['url'],

    watch: {
        url: function(value) {
            $(this.$el).css('background-image', value ? 'url(' + value + ')' : '');
        }
    }

}

</script>
