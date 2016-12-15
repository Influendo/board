<template src="./Quote.html"></template>

<style src="./Quote.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: '/api/quote'
        };
    },

    mounted() {
        $(window).on('resize', this.setFontSize);
    },

    updated() {
        this.setFontSize();
    },

    methods: {
        setFontSize() {
            let $parent  = $(this.$el);
            let $success = $parent.find('.modal.success');
            let $error   = $parent.find('.modal.error');

            // set default
            $parent.css('font-size', '');

            // decrease font-size while element scroll-height is larger than it's actual height
            while (parseInt($parent.css('font-size')) > 16 && ($success.height() > $parent.height() || $error.height() > $parent.height())) {
                console.log(parseInt($parent.css('font-size')), $parent.prop('scrollHeight'), $parent.height());
                $parent.css('font-size', '-=0.1vh');
            }
        },

        background(value) {
            if (this.response.data) {
                return 'background-image:url(' + this.response.data.contents.quotes[0].background + ')';
            }

            return '';
        }
    }

}

</script>
