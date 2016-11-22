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
		getLabel(value) {
			return value.label.split("/")[0];
		},
		getUnit(value) {
			return value.rate*1 < 0.1 ? 100 : 1;
		},
		getRate(value) {
			return Math.round(value.rate * this.getUnit(value) * 100) / 100;
		}
	}

}

</script>
