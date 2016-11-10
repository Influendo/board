<template>
    <div class="panel panel-default panel-logo">
        <div class="panel-body">
            <div class="logo" style="background-image: url(http://influendo.com/images/influendo-logo-white.png);"></div>
            <div class="clock" id="logo-clock">{{ currentTime }}</div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            updateInterval       : false,
            updateIntervalLength : 500,
            currentTime          : '',
        }
    },

    mounted() {
        this.updateInterval = setInterval(() => {
            let today = new Date();
            let h = today.getHours();
            let m = ('0' + today.getMinutes()).slice(-2);
            let s = ('0' + today.getSeconds()).slice(-2);

            this.currentTime =  h + ":" + m + ":" + s;
            console.log(this.currentTime);
        }, this.updateIntervalLength);
    }
}
</script>

<style src="./InfluendoLogo.scss" lang="sass"></style>
