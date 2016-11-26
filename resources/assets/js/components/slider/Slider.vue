<template src="./Slider.html"></template>

<style src="./Slider.scss" lang="sass"></style>

<script>

export default {

    /**
     * Component data.
     *
     * @return {Object}
     */
    data() {
        return {
            widgets: [],
            list: null,
            current: null,
            timeout: 10000,
            interval: null
        }
    },

    /**
     * On mounted event callback.
     *
     * @return {Void}
     */
    mounted() {
        this._init();
        this._create();
        this._bind();

        this.setSlide();

        setTimeout((that) => {
            $(that.$el).parent().addClass("ready");
            //that.startSlide();
        }, 50, this)
    },

    /**
     * Component methods.
     *
     * @type {Object}
     */
    methods: {

        /**
         * Initialize widgets.
         *
         * @return {Void}
         */
        _init() {
            for (var i in this.$parent.$children) {
                var board = this.$parent.$children[i];
                if (!$(board.$el).hasClass('board')) {
                    continue;
                }

                for (var j in board.$children) {
                    if ($(board.$children[j].$el).hasClass("widget")) {
                        this.widgets.push(board.$children[j]);
                    }
                }
            }
        },

        /**
         * Create list element for each widget.
         *
         * @return {Void}
         */
        _create() {
            for (var i in this.widgets) {
                $('<li><a href="#">&bull;</a></li>').appendTo(this.$el);
            }

            this.list = $(this.$el).children("li");
        },

        /**
         * Bind events.
         *
         * @return {Void}
         */
        _bind() {
            $(this.list).children("a").on("click", this._click);
        },

        /**
         * On list element click event.
         *
         * @param  {Object}  e
         * @return {Boolean}
         */
        _click(e) {
            var index = $(this.list).index($(e.target).parent());
            if (index != this.current) {
                this.setSlide(index);
            }

            return false;
        },

        /**
         * Show previous slide.
         *
         * @return {Void}
         */
        prev() {
            var index = this.getSlide() - 1;
            this.setSlide(index);
        },

        /**
         * Show next slide.
         *
         * @return {Void}
         */
        next() {
            var index = this.getSlide() + 1;
            this.setSlide(index);
        },

        /**
         * Get slide index.
         *
         * @return {Void}
         */
        getSlide() {
            return this.current;
        },

        /**
         * Set slide index.
         *
         * @return {Void}
         */
        setSlide(index) {
            if (this.widgets.length == 0) {
                return;
            }

            var status = !!this.interval;
            this.stopSlide();

            if (typeof index === "undefined") {
                return this.setSlide(0);
            }

            index = index % this.widgets.length;
            index = index + this.widgets.length;
            index = index % this.widgets.length;

            var that = this
            this.widgets[index].request({
                complete(jqXHR, textStatus) {
                    for (var i in that.widgets) {
                        that.widgets[i][index == i ? "show" : "hide"]();
                    }

                    that.current = index;
                    $(that.list)
                        .removeClass("active")
                        .eq(index)
                            .addClass("active");

                    if (status) {
                        that.startSlide();
                    }
                }
            });
        },

        /**
         * Start slideshow.
         *
         * @return {Void}
         */
        startSlide() {
            if (!!this.interval) {
                return;;
            }

            this.interval = setInterval((that) => {
                that.next();
            }, this.timeout, this);
        },

        /**
         * Stop slideshow.
         *
         * @return {Void}
         */
        stopSlide() {
            clearInterval(this.interval);
            this.interval = null;
        }

    }

}

</script>
