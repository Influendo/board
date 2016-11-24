<template src="./Inactivity.html"></template>

<script>

export default {

    /**
     * On mounted event callback.
     *
     * @return {Void}
     */
    mounted() {
        this.start();
    },

    /**
     * Component data.
     *
     * @return {Object}
     */
    data() {
        return {
            element: document.documentElement,
            events: [
                "mousedown",
                "mouseup",
                "mousemove",
                //"mouseover",
                //"mouseout",
                //"mouseenter",
                //"mouseleave",
                "click",
                "dblclick",
                "contextmenu",
                "touchstart",
                "touchend",
                "touchmove",
                "touchcancel",
                "keydown",
                "keypress",
                "keyup",
                "scroll",
                "wheel"
            ],
            className: "inactive",
            timeout: 5000,
            interval: null
        }
    },

    /**
     * Component methods.
     *
     * @return {Object}
     */
    methods: {

        /**
         * Event handler.
         *
         * @param  {Object} e
         * @return {Void}
         */
        _callback() {
            clearTimeout(this._data.interval);

            // add {className} in {timeout} miliseconds
            this._data.interval = setTimeout((that) => {
                $(that._data.element).addClass(that._data.className);
            }, this._data.timeout, this);

            // remove {className}
            $(this._data.element).removeClass(this._data.className);
        },

        /**
         * Is counter started.
         *
         * @return {Boolean}
         */
        status() {
            return !!this._data.interval;
        },

        /**
         * Start inactivity counter.
         *
         * @return {Void}
         */
        start() {
            if (this.status()) {
                return;
            }

            // with handler method we can pass this context to _callback
            if (!this._handler) {
                var that = this;
                that._handler = (e) => {
                    that._callback.call(that, e);
                }
            }

            // bind
            for (var i = 0; i < this._data.events.length; i++) {
                $(this._data.element).on(this._data.events[i] + "." + this._data.className, this._handler);
            }

            // simulate onactive
            $(this._data.element).addClass(this._data.class);
            this._handler();
        },

        /**
         * Stop inactivity counter.
         *
         * @return {Void}
         */
        stop() {
            if (!this.status()) {
                return;
            }

            // unbind
            for (var i = 0; i < this._data.events.length; i++) {
                $(this._data.element).off(this._data.events[i] + "." + this._data.className);
            }

            // clear all
            clearTimeout(this._data.interval);
            this._data.interval = null;
            this._handler = null;

            $(this._data.element).removeClass(this._data.className);
        }
    }

}

</script>
