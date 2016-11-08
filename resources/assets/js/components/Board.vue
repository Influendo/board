<template>
    <div class="board-grid">
        <div class="wrapper">
            <div class="grid-item grid-item--half">
                <widgets-nisam></widgets-nisam>
            </div>
            <div class="grid-item grid-item--half">
                <widgets-uprobot></widgets-uprobot>
            </div>
            <div class="grid-item grid-item--half">
                <widgets-image-feed></widgets-image-feed>
            </div>
            <div class="grid-item grid-item--half">
                <widgets-whats-done></widgets-whats-done>
            </div>
        </div>
    </div>
</template>

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
