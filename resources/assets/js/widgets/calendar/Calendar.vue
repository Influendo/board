<template src="./Calendar.html"></template>

<style src="./Calendar.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return $.extend({}, this.$options._defaults, {
            url: null,
            interval: null,
            delay: 500,
            lastDate: "0000-00-00",
            monthNames: [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ],
            weekdayNames: [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ]
        });
    },

	methods: {
		_callback() {
			var date = new Date();

			var response = {}
			response.y = date.getYear();
			response.Y = date.getFullYear();
			response.m = date.getMonth() + 1;
			response.M = ("0" + response.m).slice(-2);
			response.w = date.getDay();
			response.d = date.getDate();
			response.D = ("0" + response.d).slice(-2);
			response.h = date.getHours();
			response.H = ("0" + response.h).slice(-2);
			response.i = date.getMinutes();
			response.I = ("0" + response.i).slice(-2);
			response.s = date.getSeconds();
			response.S = ("0" + response.s).slice(-2);

			response.MMMM = this.monthNames[response.m - 1];
			response.MMM  = response.MMMM.substr(0, 3);
			response.WWWW = this.weekdayNames[response.w || this.weekdayNames.length - 1];
			response.WWW  = response.WWWW.substr(0, 3);

			response.lastDate = response.Y + "-" + response.M + "-" + response.D;
			response.cal      = this.response ? this.response.cal : null;
			if (!this.response || response.lastDate != this.response.lastDate) {
				var firstDayOfWeek = new Date(response.Y, response.m - 1, 1).getDay();
				var monthCountLast = new Date(response.Y, response.m - 1, 0).getDate();
				var monthCountThis = new Date(response.Y, response.m - 0, 0).getDate();

				response.cal = {};
				response.cal.table = [];
				response.cal.first = firstDayOfWeek - 1;
				response.cal.current = response.cal.first - 1 + response.d;
				response.cal.last = response.cal.first - 1 + monthCountThis;

				for (var i = 0; i < response.cal.first; i++) {
					response.cal.table.push(monthCountLast - i);
				}
				for (var i = 0; i < monthCountThis; i++) {
					response.cal.table.push(i + 1);
				}
				for (var i = 0; i < 7 * 6 - (response.cal.last + 1); i++) {
					response.cal.table.push(i + 1);
				}
			}

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
