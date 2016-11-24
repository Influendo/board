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
		getCurrency(value) {
			return value.label.split("/")[0].toLowerCase();
		},
		getLabel(value) {
			return this.getCurrency(value).toUpperCase();
		},
		getUnit(value) {
			return value.rate*1 < 0.1 ? 100 : 1;
		},
		getRate(value) {
			return (value.rate * this.getUnit(value)).toFixed(2);
		}
	}

}

</script>
