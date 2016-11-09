<template>
    <div class="panel panel-default panel-nisam">
        <div class="backdrop">NISAM</div>

        <div class="panel-body">
            <div v-if="apiIsDown" class="nisam-is-down">
                <h2>Ne radi!!!</h2>
            </div>

            <div v-if="voteStatus == 'missing'" class="nisam-pending-vote">
                <h2>Glasanje nije još počelo!</h2>
            </div>

            <div v-if="voteStatus == 'created'" class="nisam-vote-in-progress">
                <h2>Glasanje je u tijeku!</h2>
                <time class="countdown" :datetime="expirationTime">00:00:00</time>
                <ul>
                    <li v-for="place in voteData.votes">
                        {{ place.name }} - {{ place.votes }}
                    </li>
                </ul>
            </div>

            <div v-if="voteStatus == 'finished'" class="nisam-vote-finished">
                <h2>Glasanje je završeno!</h2>
                <h3>Idemo u <strong>{{ voteData.place.name }}</strong></h3>
                <h3>Nazvati mora: <strong>{{ voteData.user.name }}</strong></h3>
            </div>

            <div v-if="voteStatus == 'closed'" class="nisam-vote-finished">
                <h2>Svi su naručili!</h2>
                <h3><strong>{{ voteData.user.name }}</strong> je nazvao.</h3>
                <h3>Dobar tek!</h3>
            </div>
        </div>
    </div>
</template>

<script>
$.fn.countdown = require('jquery.countdown');

export default {
    data () {
        return {
            updateInterval       : false,
            updateIntervalLength : 10000,
            voteStatus           : '',
            voteData             : [],
            apiIsDown            : false,
            expirationTime       : false
        }
    },

    methods: {
        fetchStatus() {
            $.getJSON('/api/nisam', (voteData) => {
                this.voteData       = voteData;
                this.voteStatus     = voteData.status;
                this.apiIsDown      = false;
                this.expirationTime = new Date(voteData.expirationTime);
                $(".countdown").countDown();
            }).fail(() => {
                this.apiIsDown = true;
                this.voteData  = [];
            });
        }
    },

    mounted() {
        this.fetchStatus();

        // Also setup an interval
        this.updateInterval = setInterval(() => {
            this.fetchStatus();
        }, this.updateIntervalLength);
    }
}
</script>

<style>
.panel-nisam {
    background: rgba(82,190,127,0.85);
    color: #fff;
}

.panel-nisam .backdrop {
    opacity: 0.2;
    color: #ccc;
}

.panel-body {
    height: 100%;
}

.nisam-pending-vote {
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}
.nisam-pending-vote h2 {
    font-size: 62px;
    margin: 0;
}

.nisam-vote-in-progress {
    text-align: center;
    height: 100%;
}
.nisam-vote-in-progress h2 {
    font-size: 42px;
}
.nisam-vote-in-progress ul {
    margin: 10px 0 0 0;
    padding: 0;
    height: 5em;
    overflow: hidden;
    list-style-type: none;
    font-size: 22px;
}

.nisam-vote-finished {
    text-align: center;
    height: 100%;
}
.nisam-vote-finished h2 {
    font-size: 42px;
}
.nisam-vote-finished h3 {
    font-size: 36px;
}

.nisam-is-down {
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}
.nisam-is-down h2 {
    font-size: 62px;
    margin: 0;
    color: #c00;
    opacity: 0.8;
}

.countdown {
    font-size: 22px;
    border: 1px solid #666;
    border-radius: 5px;
    margin: 5px 0 16px 0;
    padding: 5px 10px;
}

.countdown .label {
    display: none;
}
</style>
