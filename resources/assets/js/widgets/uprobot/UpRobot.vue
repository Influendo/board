<template>
    <div class="panel panel-default">
        <div class="backdrop">UPTIME</div>

        <div class="panel-body">
            <div class="monitors">
                <table class="table status-table" v-if="monitors" style="width: auto;">
                    <tr v-for="monitor in monitors">
                        <td>
                            <span class="label label-success" v-if="monitor.status == 2">&nbsp; <i class="fa fa-arrow-circle-up"></i> &nbsp;</span>
                            <span class="label label-danger" v-if="monitor.status != 2">&nbsp; <i class="fa fa-arrow-circle-down"></i> &nbsp;</span>
                        </td>
                        <td>{{ monitor.friendlyname }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                updateInterval       : false,
                updateIntervalLength : 30000,
                monitors : []
            }
        },

        methods: {
            fetchMonitors() {
                $.getJSON('/api/uptimerobot', function(result) {
                    this.monitors = result.monitors;
                }.bind(this));
            }
        },

        mounted() {
            this.fetchMonitors();

            // Also setup an interval
            this.updateInterval = setInterval(() => {
                this.fetchMonitors();
            }, this.updateIntervalLength);
        }
    }
</script>

<style>
.monitors {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.status-table td {
    font-size: 19px;
    padding: 6px;
}
</style>
