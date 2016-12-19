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
            $status: null,
            $bullets: null,
            widgets: [],
            list: null,
            current: null,
            status: 'play',
            intervalDisplay: null,
            timeoutDisplay: 5000,
            intervalSlide: null,
            timeoutSlide: 10000
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

            if (that.status == 'play') {
                that.startSlide();
            }
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
            this.$status = $(this.$el).children('.slider-status');
            this.$bullets = $(this.$el).children('.slider-bullets');

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
                $('<li><a href="#">&bull;</a></li>').appendTo(this.$bullets);
            }

            this.list = $(this.$bullets).children('li');
        },

        /**
         * Bind events.
         *
         * @return {Void}
         */
        _bind() {
            $(document)
                .on('mousedown mouseup mousemove click dblclick contextmenu touchstart touchend touchmove touchcancel scroll wheel', this.show);

            $(document)
                .on('keyup', this._keyup);

            $(this.list).children('a')
                .on('click', this._click);
        },

        /**
         * On keyup event.
         *
         * @param  {Object} e
         * @return {Mixed}
         */
        _keyup(e) {
            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which === 13) { return !!this.toggle(); }

            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which === 27) { this.show(); return !!this.abortAll(); };

            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which === 36) { this.show(); return !!this.setSlide(0); }
            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which === 37) { this.show(); return !!this.prevSlide(); }
            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which === 39) { this.show(); return !!this.nextSlide(); }
            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which === 35) { this.show(); return !!this.setSlide(-1); }

            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which === 88) { this.show(); return !!this.startSlide(); }
            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which === 67) { this.show(); return !!this.stopSlide(); }
            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which === 32) { this.show(); return !!this.toggleSlide(); }

            if (!e.altKey && !e.shiftKey && !e.ctrlKey && e.which >= 48 && e.which <= 57) {
                let index = e.which - 49;
                if (index == -1) index = 9;

                if (this.widgets.length > index) {
                    this.show();
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
         * Show slider
         *
         * @return {Void}
         */
        show() {
            $(document.documentElement)
                .addClass('slider-active');

            clearInterval(this.intervalDisplay);
            this.intervalDisplay = setInterval((that) => {
                that.hide();
            }, this.timeoutDisplay, this);
        },

        /**
         * Hide slider
         *
         * @return {Void}
         */
        hide() {
            clearInterval(this.intervalDisplay);
            this.intervalDisplay = null;

            $(document.documentElement)
                .removeClass('slider-active');
        },

        /**
         * Show/hide slider
         *
         * @return {Void}
         */
        toggle() {
            if (this.intervalDisplay) {
                this.hide();
            }
            else {
                this.show();
            }
        },

        /**
         * Show previous slide.
         *
         * @return {Void}
         */
        prevSlide() {
            let index = this.getSlide() - 1;
            this.setSlide(index);
        },

        /**
         * Show next slide.
         *
         * @return {Void}
         */
        nextSlide() {
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

            $(this.list)
                .eq(index)
                    .addClass('request');

            clearInterval(this.intervalSlide);
            this.intervalSlide = null;

            this.abortAll();

            let that = this;
            this.widgets[index].request({
                complete(jqXHR, textStatus) {
                    $(that.list)
                        .removeClass('request');

                    if (that.status == 'play') {
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
            if (!!this.intervalSlide) {
                return;;
            }

            this.status = 'play';

            this.intervalSlide = setInterval((that) => {
                that.nextSlide();
            }, this.timeoutSlide, this);
        },

        /**
         * Stop slideshow.
         *
         * @return {Void}
         */
        stopSlide() {
            if (!this.intervalSlide) {
                return;;
            }

            this.status = 'pause';

            clearInterval(this.intervalSlide);
            this.intervalSlide = null;
        },

        /**
         * Toggle slideshow.
         *
         * @return {Void}
         */
        toggleSlide() {
            if (this.status == 'play') {
                this.stopSlide();
            }
            else {
                this.startSlide();
            }
        }

    }

}

</script>
