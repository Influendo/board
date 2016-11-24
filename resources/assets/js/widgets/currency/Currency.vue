<template src="./Currency.html"></template>

<style src="./Currency.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return $.extend({}, this.$options._defaults, {
            url: "/api/currency",
        });
    },

	methods: {
		getCurrency(key, value) {
			return key.toLowerCase();
		},
		getLabel(key, value) {
			return key.toUpperCase();
		},
		getRateReal(key, value) {
			return 1 / value;
		},
		getUnit(key, value) {
			return this.getRateReal(key, value) < 0.1 ? 100 : 1;
		},
		getRate(key, value) {
			return (this.getRateReal(key, value) * this.getUnit(key, value)).toFixed(5);
		}
	}

}

</script>
