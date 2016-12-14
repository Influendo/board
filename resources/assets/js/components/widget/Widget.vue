<template src="./Widget.html"></template>

<style src="./Widget.scss" lang="sass"></style>

<script>

export default {

    /**
     * Component data
     *
     * @return {Object}
     */
    data() {
        return {
            url: "/api/widget",
            response: {
                data: null,
                error: null
            }
        }
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
        _success(data, textStatus, jqXHR) {
            if (data && data.error) {
                return this._error(null, null, {
                    message: data.error.message || data.error
                });
            }

            this.response.data = data || {};
            this.response.error = null;

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
        _error(jqXHR, textStatus, errorThrown) {
            this.response.error = errorThrown.message || jqXHR.statusText;
            this.response.data = null;

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
        _complete(jqXHR, textStatus) {
            // pass
        },

        /**
         * Show widget.
         *
         * @return {Void}
         */
        show() {
            $(this.$el)
                .addClass("active");
        },

        /**
         * Hide widget.
         *
         * @return {Void}
         */
        hide() {
            $(this.$el)
                .removeClass("active");
        },

        /**
         * Send ajax request.
         *
         * @param  {Mixed} options
         * @return {Void}
         */
        request(options) {
            $(this.$el)
                .removeClass("error")
                .removeClass("success")
                .addClass("loading");

            var o = $.extend({}, {
                dataType: "json",
                url: this.url,
                timeout: 5000,
                success: this._success,
                error: this._error,
                complete: this._complete
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
