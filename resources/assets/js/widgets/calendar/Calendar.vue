<template src="./Calendar.html"></template>

<style src="./Calendar.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            interval: null,
            delay: 500,
            lastDate: '0000-00-00',
            monthNames: window.Locale.months,
            weekdayNames: window.Locale.weekdays
        }
    },

    mounted() {
        $(this.$el)
            .addClass('success');

        this.start();
    },

    methods: {
        _callback() {
            let date = new Date();
            let result = {};

            result.y = date.getYear();
            result.Y = date.getFullYear();
            result.m = date.getMonth() + 1;
            result.M = ('0' + result.m).slice(-2);
            result.w = date.getDay();
            result.d = date.getDate();
            result.D = ('0' + result.d).slice(-2);
            result.h = date.getHours();
            result.H = ('0' + result.h).slice(-2);
            result.i = date.getMinutes();
            result.I = ('0' + result.i).slice(-2);
            result.s = date.getSeconds();
            result.S = ('0' + result.s).slice(-2);

            result.MMMM = this.monthNames[result.m - 1];
            result.MMM  = result.MMMM.substr(0, 3);
            result.WWWW = this.weekdayNames[result.w ? result.w - 1 : this.weekdayNames.length - 1];
            result.WWW  = result.WWWW.substr(0, 3);

            result.lastDate = result.Y + '-' + result.M + '-' + result.D;
            result.cal      = this.response.data ? this.response.data.cal : null;
            if (!this.response.data || result.lastDate != this.response.data.lastDate) {
                let firstDayOfWeek = new Date(result.Y, result.m - 1, 1).getDay();
                let monthCountLast = new Date(result.Y, result.m - 1, 0).getDate();
                let monthCountThis = new Date(result.Y, result.m - 0, 0).getDate();

                if (firstDayOfWeek == 0) {
                    firstDayOfWeek += 7;
                }

                result.cal = {};
                result.cal.table = [];
                result.cal.first = firstDayOfWeek - 1;
                result.cal.current = result.cal.first - 1 + result.d;
                result.cal.last = result.cal.first - 1 + monthCountThis;

                // append whole week to previous month if month starts with monday
                if (firstDayOfWeek == 1) {
                    result.cal.first += 7;
                    result.cal.current += 7;
                    result.cal.last += 7;
                }

                // last month days
                for (var i = 0; i < result.cal.first; i++) {
                    result.cal.table.push(monthCountLast - (result.cal.first - i - 1));
                }

                // this month days
                for (var i = 0; i < monthCountThis; i++) {
                    result.cal.table.push(i + 1);
                }

                // next month days (fill 7x6 table)
                for (var i = 0; i < 7 * 6 - (result.cal.last + 1); i++) {
                    result.cal.table.push(i + 1);
                }
            }

            this.response.data = result;
        },
        request(options) {
            if (typeof (options || {}).success === 'function') options.success();
            if (typeof (options || {}).complete === 'function') options.complete();
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
    }
}

</script>
