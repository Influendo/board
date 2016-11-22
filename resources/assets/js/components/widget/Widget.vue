<template src="./Widget.html"></template>

<style src="./Widget.scss" lang="sass"></style>

<script>

export default {

    /**
     * Default component data.
     *
     * @type {Object}
     */
    _defaults: {
        url: "/api/widget",
        response: null
    },

    /**
     * Component data
     *
     * @return {Object}
     */
    data: function() {
        return $.extend({}, this._defaults);
    },

    /**
     * Component methods
     *
     * @type {Object}
     */
    methods: {

        /**
         * Ajax success event callback
         *
         * @param  {Object} data
         * @param  {String} textStatus
         * @param  {Object} jqXHR
         * @return {Void}
         */
        _success: function(data, textStatus, jqXHR) {
            if (data) {
                this.response = data;
            }

            $(this.$el)
                .removeClass("loading")
                .addClass("success");
        },

        /**
         * Ajax error event callback
         *
         * @param  {Object} jqXHR
         * @param  {String} textStatus
         * @param  {String} errorThrown
         * @return {Void}
         */
        _error: function(jqXHR, textStatus, errorThrown) {
            this.response = {
                error: errorThrown.message || jqXHR.statusText
            }

            $(this.$el)
                .removeClass("loading")
                .addClass("error");
        },

        /**
         * Ajax complete event callback
         *
         * @param  {Object} jqXHR
         * @param  {String} textStatus
         * @return {Void}
         */
        _complete: function(jqXHR, textStatus) {
            // pass
        },

        /**
         * Show widget.
         *
         * @return {Void}
         */
        show: function() {
            $(this.$el)
                .addClass("active");
        },

        /**
         * Hide widget.
         *
         * @return {Void}
         */
        hide: function() {
            $(this.$el)
                .removeClass("active");
        },

        /**
         * Send ajax request.
         *
         * @param  {Mixed} options
         * @return {Void}
         */
        request: function(options) {
            this.response = null;

            $(this.$el)
                .removeClass("error")
                .removeClass("success")
                .addClass("loading");

            var o = $.extend({}, {
                dataType: "json",
                url: this.url,
                success: this._success,
                error: this._error,
                complete: this._complete,
            }, options || {});

            if (o.url) {
                $.ajax(o);
            }
            else {
                o.success();
                o.complete();
            }
        }
    }

}

</script>
