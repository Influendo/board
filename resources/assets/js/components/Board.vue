<template>
    <div class="board-grid">
        <div class="wrapper">
            <div class="grid-item grid-item--half">
                <widgets-nisam></widgets-nisam>
            </div>
            <div class="grid-item">
                <widgets-uprobot></widgets-uprobot>
            </div>
            <div class="grid-item">
                <widgets-currency></widgets-currency>
            </div>
            <div class="grid-item grid-item--half">
                <widgets-influendo-logo></widgets-influendo-logo>
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
