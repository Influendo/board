<template>
    <div class="panel panel-default panel-logo">
        <div class="panel-body">
            <div class="logo-slides">
                <transition-group name="fade">
                    <div class="logo" style="background-color: #3fa9f5; background-image: url(/img/influendo-logo-white.png);" v-if="showLogo == 1" v-bind:key="1"></div>
                    <div class="logo" style="background-image: url(/img/optimizepress-logo.png);"   v-if="showLogo == 2" v-bind:key="2"></div>
                </transition-group>
            </div>

            <div class="clock" id="logo-clock">{{ currentTime }}</div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            updateInterval            : false,
            updateIntervalLength      : 15000,
            updateClockInterval       : false,
            updateClockIntervalLength : 500,
            currentTime               : '',
            showLogo                  : 1,
        }
    },

    mounted() {
        this.updateClockInterval = setInterval(() => {
            let today = new Date();
            let h = today.getHours();
            let m = ('0' + today.getMinutes()).slice(-2);
            let s = ('0' + today.getSeconds()).slice(-2);

            this.currentTime =  h + ":" + m + ":" + s;
        }, this.updateClockIntervalLength);

        this.updateInterval = setInterval(() => {
            this.showLogo++;

            if (this.showLogo > $(".logo").length + 1) {
                this.showLogo = 1;
            }
        }, this.updateIntervalLength);
    }
}
</script>

<style src="./InfluendoLogo.scss" lang="sass"></style>
