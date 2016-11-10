<template src="./Board.html"></template>

<script>
import Packery from 'packery';

export default {
    mounted() {
        let pckry = new Packery('.board-grid .wrapper', {
            itemSelector: '.grid-item',
            gutter: 0
        });
    }
}
</script>
