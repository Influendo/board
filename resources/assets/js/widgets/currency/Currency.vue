<template>
    <div class="panel panel-default panel-currency">
        <div class="backdrop">TEČAJ</div>

        <div class="panel-body">
            <table class="table currency-rate-table" v-if="rates">
                <tbody>
                    <tr v-for="rate in rates">
                        <th width="50%">{{ rate.label }}:</th>
                        <td width="50%"><strong>{{ rate.rate }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            updateInterval       : false,
            updateIntervalLength : 10000,
            rates: []
        }
    },

    methods: {
        fetchRates() {
            $.getJSON('/api/currency', (rates) => {
                this.rates = rates;
            }).fail(() => {

            });
        }
    },

    mounted() {
        this.fetchRates();

        // Also setup an interval
        this.updateInterval = setInterval(() => {
            this.fetchRates();
        }, this.updateIntervalLength);
    }
}
</script>

<style>
.panel-currency {
    background: rgba(34,98,123,0.65);
    color: #fff;
}

.panel-currency .backdrop {
    opacity: 0.05;
    color: #ccc;
}

.currency-rate-list {
    list-style-type: none;
    text-align: center;
    font-size: 30px;
}

.currency-rate-table {
    font-size: 30px;
}

.currency-rate-table tr {
    vertical-align: bottom;
}

.currency-rate-table th {
    font-weight: 100;
    text-align: right;
    vertical-align: bottom;
    border: none !important;
}

.currency-rate-table td {
    font-size: 30px;
    vertical-align: bottom;
    border: none !important;
}

.currency-rate-list li {
    letter-spacing: 1px;
}

.currency-rate-list strong {
    font-size: 30px;
}
</style>
