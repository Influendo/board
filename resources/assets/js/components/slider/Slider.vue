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
            $(that.$el).parent().addClass('ready');
            that.startSlide();
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
                let board = this.$parent.$children[i];
                if (!$(board.$el).hasClass('board')) {
                    continue;
                }

                for (var j in board.$children) {
                    if ($(board.$children[j].$el).hasClass('widget')) {
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

            this.list = $(this.$el).children('li');
        },

        /**
         * Bind events.
         *
         * @return {Void}
         */
        _bind() {
            $(document)
                .on('keypress', this._keypress);

            $(this.list).children('a')
                .on('click', this._click);
        },

        /**
         * On keypress event.
         *
         * @param  {Object} e
         * @return {Mixed}
         */
        _keypress(e) {
            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.keyCode  === 27) return !!this.abortAll();

            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.charCode === 32) return !!this.toggleSlide();
            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.keyCode  === 37) return !!this.prev();
            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.keyCode  === 39) return !!this.next();

            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.charCode >= 48 && e.charCode <= 57) {
                let index = e.charCode - 49;
                if (index == -1) index = 9;

                if (this.widgets.length > index) {
                    return !!this.setSlide(index);
                }
            }
        },

        /**
         * On list element click event.
         *
         * @param  {Object}  e
         * @return {Boolean}
         */
        _click(e) {
            let index = $(this.list).index($(e.target).parent());

            return !!this.setSlide(index);
        },

        /**
         * Abort all ajax requests
         *
         * @return {Void}
         */
        abortAll() {
            for (var i = 0; i < this.widgets.length; i++) {
                this.widgets[i].abort();
            }
        },

        /**
         * Show previous slide.
         *
         * @return {Void}
         */
        prev() {
            let index = this.getSlide() - 1;
            this.setSlide(index);
        },

        /**
         * Show next slide.
         *
         * @return {Void}
         */
        next() {
            let index = this.getSlide() + 1;
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
            if (typeof index === 'undefined') {
                return this.setSlide(0);
            }

            index = index % this.widgets.length;
            index = index + this.widgets.length;
            index = index % this.widgets.length;

            if (this.widgets.length == 0 || index == this.current) {
                return;
            }
            if (this.widgets[index].xhr && [1,2,3].indexOf(this.widgets[index].xhr.readyState) !== -1) {
                return;
            }

            let status = !!this.interval;
            this.stopSlide();
            this.abortAll();

            let that = this;
            this.widgets[index].request({
                complete(jqXHR, textStatus) {
                    if (status) {
                        that.startSlide();
                    }

                    if (textStatus === 'abort' && jqXHR.status === 0) {
                        return;
                    }

                    for (var i in that.widgets) {
                        that.widgets[i][index == i ? 'show' : 'hide']();
                    }

                    that.current = index;
                    $(that.list)
                        .removeClass('active')
                        .eq(index)
                            .addClass('active');

                    that.widgets[index]._complete.call(that.widgets[index], jqXHR, textStatus);
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
            if (!this.interval) {
                return;;
            }

            clearInterval(this.interval);
            this.interval = null;
        },

        /**
         * Toggle slideshow.
         *
         * @return {Void}
         */
        toggleSlide() {
            if (!!this.interval) {
                this.stopSlide();
            }
            else {
                this.startSlide();
            }
        }

    }

}

</script>
