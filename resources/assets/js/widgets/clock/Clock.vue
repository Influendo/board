<template src="./Clock.html"></template>

<style src="./Clock.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return $.extend({}, this.$options._defaults, {
            url: null,
            interval: null,
            delay: 500
        });
    },

	methods: {
		_callback() {
			var date = new Date();

			var response = {}
			response.y = date.getYear();
			response.Y = date.getFullYear();
			response.m = date.getMonth();
			response.M = ("0" + response.m).slice(-2);
			response.d = date.getDate();
			response.D = ("0" + response.d).slice(-2);
			response.h = date.getHours();
			response.H = ("0" + response.h).slice(-2);
			response.i = date.getMinutes();
			response.I = ("0" + response.i).slice(-2);
			response.s = date.getSeconds();
			response.S = ("0" + response.s).slice(-2);

			this.response = response;
		},
		status() {
			return !!this.interval;
		},
		start() {
			if (this.status()) {
				return;
			}

			this.interval = setInterval(this._callback, this.delay);
		},
		stop() {
			clearInterval(this.interval);
			this.interval = null;
		}
	},

	mounted() {
		this.start();
	}
}

</script>
