<template src="./UpRobot.html"></template>

<script>
    export default {
        data () {
            return {
                updateInterval       : false,
                updateIntervalLength : 60000,
                monitors : []
            }
        },

        methods: {
            fetchMonitors() {
                let audio = new Audio('/sounds/alert.mp3');

                $.getJSON('/api/uptimerobot', function(result) {
                    this.monitors = result.monitors;

                    result.monitors.forEach(monitor => {
                        if (monitor.status != 2) {
                            audio.play();
                        }
                    });
                }.bind(this));
            }
        },

        mounted() {
            this.fetchMonitors();

            // Also setup an interval
            this.updateInterval = setInterval(() => {
                this.fetchMonitors();
            }, this.updateIntervalLength);
        }
    }
</script>

<style src="./UpRobot.scss"></style>
