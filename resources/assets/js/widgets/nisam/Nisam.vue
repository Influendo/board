<template src="./Nisam.html"></template>

<script>
$.fn.countdown = require('jquery.countdown');

export default {
    data () {
        return {
            updateInterval       : false,
            updateIntervalLength : 10000,
            voteStatus           : '',
            voteData             : [],
            apiIsDown            : false,
            expirationTime       : false
        }
    },

    methods: {
        fetchStatus() {
            $.getJSON('/api/nisam', (voteData) => {
                this.voteData       = voteData;
                this.voteStatus     = voteData.status;
                this.apiIsDown      = false;
                this.expirationTime = new Date(voteData.expirationTime);
                $(".countdown").countDown();
            }).fail(() => {
                this.apiIsDown = true;
                this.voteData  = [];
            });
        }
    },

    mounted() {
        this.fetchStatus();

        // Also setup an interval
        this.updateInterval = setInterval(() => {
            this.fetchStatus();
        }, this.updateIntervalLength);
    }
}
</script>

<style src="./Nisam.scss"></style>
