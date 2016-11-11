<template src="./Currency.html"></template>

<script>
export default {
    data () {
        return {
            updateInterval       : false,
            updateIntervalLength : (30 * 60000),
            rates: []
        }
    },

    methods: {
        fetchRates() {
            $.getJSON('/api/currency', (rates) => {
                this.rates = rates;
            }).fail(() => {

            });
        }
    },

    mounted() {
        this.fetchRates();

        // Also setup an interval
        this.updateInterval = setInterval(() => {
            this.fetchRates();
        }, this.updateIntervalLength);
    }
}
</script>

<style src="./Currency.scss" lang="sass"></style>
