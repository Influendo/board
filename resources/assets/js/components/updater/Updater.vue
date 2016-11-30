<template src="./Updater.html"></template>

<style src="./Updater.scss" lang="sass"></style>

<script>

export default {

    data() {
        return {
            url: "/api/version",
            interval: null,
            version: null,
            timeout: 15*60*1000,
            delay: 5
        }
    },

    mounted() {
        this.start();
    },

    methods: {
        _countdown() {
            this.delay--;

            if (this.delay < -1) {
                this.stop();
                this.reload();
            }
        },

        _request() {
            this.request();
        },

        _success(data, textStatus, jqXHR) {
            if (this.version !== null &&  this.version != data.version) {
                this.countdown();
            }

            this.version = data.version;
        },

        _error(jqXHR, textStatus, errorThrown) {
            // pass
        },

        start() {
            if (!!this.interval) {
                return;;
            }

            $(this.$el)
                .addClass("active")
                .data("updater-delay", this.delay);

            this.interval = setInterval(this._request, this.timeout);
            this._request();
        },

        stop() {
            clearInterval(this.interval);
            this.interval = null;

            if (this.delay < -1) {
                return;
            }

            this.delay = $(this.$el).data("updater-delay");

            $(this.$el)
                .removeData("updater-delay")
                .removeClass("active")
                .removeClass("countdown");
        },

        request() {
            $.ajax({
                dataType: "json",
                url: this.url,
                timeout: 5000,
                success: this._success,
                error: this._error
            });
        },

        countdown() {
            this.stop();

            $(this.$el)
                .addClass("countdown")
                .data("updater-delay", this.delay);

            this.interval = setInterval(this._countdown, 1000);
            this._countdown();
        },

        reload() {
            this.delay = -1;
            window.location.reload();
        }
    }

}

</script>
