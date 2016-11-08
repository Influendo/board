<template>
    <div class="panel panel-default">
        <div class="backdrop">NISAM</div>

        <div class="panel-body">
            <div class="alert alert-danger" v-if="isApiDown">
                <h4>API error!</h4>
            </div>

            <div v-if="voteStatus == 'missing'" class="nisam-pending-vote">
                <h2>Glasanje nije još počelo!</h2>
            </div>

            <div v-if="voteStatus == 'created'" class="nisam-vote-in-progress">
                <h2>Glasanje je u tijeku!</h2>
                <ul>
                    <li v-for="place in this.voteData.votes">
                        {{ place.name }} - {{ place.votes }}
                    </li>
                </ul>
            </div>

            <div v-if="voteStatus == 'finished' || voteStatus == 'closed'" class="nisam-vote-finished">
                <h2>Glasanje je završeno!</h2>
                <h3>Idemo u <strong>{{ this.voteData.place.name }}</strong></h3>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                updateInterval       : false,
                updateIntervalLength : 10000,
                voteStatus           : '',
                voteData             : [],
                isApiDown            : false
            }
        },

        methods: {
            fetchStatus() {
                $.getJSON('/api/nisam', function(voteData) {
                    this.voteData = voteData;
                    this.voteStatus = voteData.status;
                }.bind(this)).done(function() {
                    this.isApiDown = false;
                }).fail(function() {
                    this.isApiDown = true;
                    this.voteData = [];
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
    margin: 0;
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
</style>
