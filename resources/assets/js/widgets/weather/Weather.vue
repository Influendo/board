<template src="./Weather.html"></template>

<style src="./Weather.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: '/api/weather',
            response: {
                data: null,
                error: null
            }
        }
    },

    methods: {
        iconWeather(value) {
            return 'http://openweathermap.org/img/w/' + value + '.png';
        },

        formatTemp(value) {
            return (Math.round(value * 10) / 10) + '°C';
        },

        formatCloudiness(value) {
            return value + '%';
        },

        formatHumidity(value) {
            return value + '%';
        },

        formatPressure(value) {
            //return value + 'hPa';
            return Math.round(value / 1000) + 'bar';
        },

        formatTime(value, hideDate) {
            let date = new Date(value * 1000);
            let result = '';

            if (!hideDate) {
                result += ''
                    + ('0' + date.getFullYear()).slice(-4)
                    + '-'
                    + ('0' + (date.getMonth() + 1)).slice(-2)
                    + '-'
                    + ('0' + date.getDate()).slice(-2)
                    + ' ';
            }

            result += ''
                + ('0' + date.getHours()).slice(-2)
                + ':'
                + ('0' + date.getMinutes()).slice(-2)
                + ':'
                + ('0' + date.getSeconds()).slice(-2);

            return result;
        },

        formatWind(value, direction) {
            value = Math.round(value * 10) / 10;
            direction = Math.round(direction * 10) / 10;
            while (direction <   0) direction += 360;
            while (direction > 360) direction -= 360;

            let val = Math.floor((direction / 22.5) + 0.5);
            let arr = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
            let compas = arr[(val % 16)];

            let result = '';
            if (!isNaN(direction)) result += compas + ' ';
            if (!isNaN(value))     result += value  + 'm/s';
            result = result.replace(/^\s+|\s+$/g, '');

            return result;
        }
    }

}

</script>
