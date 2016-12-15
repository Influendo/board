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
            url: null,
            xhr: null,
            response: {
                data: null,
                error: null
            }
        }
    },

    mounted() {
        $(window).on('resize', this._auto_font_size);
    },

    /**
     * On re-render event
     *
     * @return {Void}
     */
    updated() {
        this._auto_font_size();
    },

    /**
     * Component methods
     *
     * @type {Object}
     */
    methods: {

        /**
         * Set widget font-size to fit screen
         *
         * @return {Void}
         */
        _auto_font_size() {
            let $parent  = $(this.$el);
            if (!$parent.hasClass('widget-auto-font-size')) {
                return;
            }

            let $success = $parent.find('.modal.success');
            let $error   = $parent.find('.modal.error');

            // set default
            $parent.css('font-size', '');

            // decrease font-size while element scroll-height is larger than it's actual height
            while (parseInt($parent.css('font-size')) > 16 && ($success.height() > $parent.height() || $error.height() > $parent.height())) {
                $parent.css('font-size', '-=0.1vh');
            }
        },

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
            if (textStatus === 'abort' && jqXHR.status === 0) {
                return;
            }

            this.response.error = errorThrown.message || jqXHR.statusText;
            this.response.data = null;
        },

        /**
         * Ajax complete event callback
         *
         * @param  {Object} jqXHR
         * @param  {String} textStatus
         * @return {Void}
         */
        _complete(jqXHR, textStatus) {
            $(this.$el)
                .addClass(this.response.data ? 'success' : '_temp')
                .addClass(this.response.error ? 'error' : '_temp')
                .removeClass('loading')
                .removeClass('_temp');
        },

        /**
         * Show widget.
         *
         * @return {Void}
         */
        show() {
            $(this.$el)
                .addClass('active');
        },

        /**
         * Hide widget.
         *
         * @return {Void}
         */
        hide() {
            $(this.$el)
                .removeClass('active');
        },

        /**
         * Send ajax request.
         *
         * @param  {Mixed} options
         * @return {Void}
         */
        request(options) {
            $(this.$el)
                .addClass('loading');

            let o = $.extend({}, {
                dataType: 'json',
                url: this.url,
                timeout: 5000,
                success: this._success,
                error: this._error,
                complete: this._complete
            }, options || {});

            if (o.url) {
                this.xhr = $.ajax(o);
            }
            else {
                o.success();
                o.complete();
            }
        },

        /**
         * Abort ajax request.
         *
         * @return {Void}
         */
        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }
    }

}

</script>
