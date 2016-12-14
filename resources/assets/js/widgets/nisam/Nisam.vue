<template src="./Nisam.html"></template>

<style src="./Nisam.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: "/api/nisam",
            interval: null,
            delay: 500,
            counter: "00:00:00"
        };
    },

    mounted() {
        this.startCountdown();
    },

    methods: {
        _callback() {
            if (this.response.data && this.response.data.expirationTime) {
                let diff = (new Date(this.response.data.expirationTime) - new Date()) / 1000;
                if (diff > 0) {
                    this.counter = ""
                        + ("0" + (Math.floor(diff / 3600) % 24)).slice(-2)
                        + ":"
                        + ("0" + (Math.floor(diff / 60) % 60)).slice(-2)
                        + ":"
                        + ("0" + (Math.floor(diff / 1) % 60)).slice(-2);

                    return;
                }
            }

            this.counter = "00:00:00";
        },

        getVotes() {
            if (!this.response.data.votes) {
                return 0;
            }

            let result = [];
            this.response.data.votes.forEach((value) => {
                if (value.votes) {
                    result.push(value);
                }
            });

            result.sort((a,b) => {
                if (a.votes < b.votes) return +1;
                if (a.votes > b.votes) return -1;
                //if (a.name  < b.name)  return +1;
                //if (a.name  > b.name)  return -1;
                if (a.name.localeCompare(b.name)) return a.name.localeCompare(b.name);
                if (a.id    < b.id)    return +1;
                if (a.id    > b.id)    return -1;

                return 0;
            });

            return result;
        },

        startCountdown() {
            if (!!this.interval) {
                return;;
            }

            this.interval = setInterval(this._callback, this.delay);
        },

        stopCountdown() {
            clearInterval(this.interval);
            this.interval = null;
            this.counter = "00:00:00";
        }

    }

}

</script>
