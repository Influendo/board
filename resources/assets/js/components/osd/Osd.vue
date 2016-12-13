<template src="./Osd.html"></template>

<style src="./Osd.scss" lang="sass"></style>

<script>

export default {

    /**
     * Component data.
     *
     * @return {Object}
     */
    data() {
        return {
            ajax: {
                error: null,
                timestamp: null,
                readyState: null,
                responseJSON: null,
                responseText: null,
                status: null,
                statusText: null,
                dataType: null,
                timeout: null,
                type: null,
                url: null,
            }
        }
    },

    /**
     * On mounted event callback.
     *
     * @return {Void}
     */
    mounted() {
        $(document)
            .ajaxSuccess(this._handler_ajax_callback)
            .ajaxError(this._handler_ajax_callback)
            .on('keyup', this._handler_document_keyup);
    },

    /**
     * Component methods.
     *
     * @type {Object}
     */
    methods: {

        _handler_document_keyup(event) {
            if (event.altKey && event.ctrlKey && event.shiftKey && (event.key == 'o' || event.key == 'O')) {
                this.toggle();
            }
        },

        /**
         * Ajax success handler.
         *
         * @param  {Object} event
         * @param  {Object} xhr
         * @param  {Object} settings
         * @param  {String} thrownError
         * @return {Void}
         */
        _handler_ajax_callback(event, xhr, settings, thrownError) {
            var result = {
                error: null,
                timeStamp: event.timeStamp,
                readyState: xhr.readyState,
                responseJSON: xhr.responseJSON,
                responseText: xhr.responseText,
                status: xhr.status,
                statusText: xhr.statusText,
                dataType: settings.dataType,
                timeout: settings.timeout,
                type: settings.type,
                url: settings.url
            }

            this.ajax = result;
        },

        /**
         * Format
         *
         * @param  {Mixed}  value
         * @return {String}
         */
        format(key, value) {
            if (typeof value === 'undefined') {
                value = null;
            }

            if (key == 'timeStamp' && value) {
                value = new Date(value).toISOString();
            }

            return JSON.stringify(value, null, 4).replace(/\n/g, '\n                ');
        },

        /**
         * Toggle display
         *
         * @return {Void}
         */
        toggle() {
            $(this.$el).toggleClass('active');
        }

    }

}

</script>
