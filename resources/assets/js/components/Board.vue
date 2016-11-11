<template src="./Board.html"></template>

<script>
import Packery from 'packery';

export default {
    data () {
        return {
            updateInterval            : false,
            updateIntervalLength      : 30000,
        }
    },

    mounted() {
        this.updateInterval = setInterval(() => {
            $.getJSON('/api/status', (status) => {
                if (status.should_refresh) {
                    document.location = document.location;
                }
            }).fail(() => {
                // Ha?
            });
        }, this.updateIntervalLength);

        let pckry = new Packery('.board-grid .wrapper', {
            itemSelector: '.grid-item',
            gutter: 0
        });
    }
}
</script>
