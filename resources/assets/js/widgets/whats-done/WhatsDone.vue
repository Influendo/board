<template>
    <div class="panel panel-default panel-whatsdone">
        <div class="backdrop">WHATSDONE</div>

        <div class="panel-body">
            <table class="table whatsdone-table" v-if="users" width="100%">
                <tbody>
                    <tr v-for="user in users" v-if="user.tasks.length">
                        <th>{{ user.name }}</th>
                        <td>
                            <div class="all-tasks" v-if="user.tasks">
                                <span v-for="task in user.tasks">
                                    <span v-if="task">{{ task.body }}, </span>
                                </span>
                            </div>
                        </td>
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
            users: []
        }
    },

    methods: {
        fetchUsers() {
            $.getJSON('/api/whatsdone', (users) => {
                this.users = users;
            }).fail(() => {

            });
        }
    },

    mounted() {
        this.fetchUsers();

        // Also setup an interval
        this.updateInterval = setInterval(() => {
            this.fetchUsers();
        }, this.updateIntervalLength);
    }
}
</script>

<style>
.panel-whatsdone {
    background: rgba(245,245,245,0.95);
}

.panel-whatsdone .backdrop {
    opacity: 0.1;
}

.whatsdone-table {
    width: 100% !important;
    line-height: 120%;
}

.whatsdone-table tr {
    vertical-align: bottom;
}

.whatsdone-table th {
    font-weight: 100;
    font-size: 15px;
    text-align: right;
    vertical-align: bottom;
    border: none !important;
    white-space: nowrap;
    color: rgb(243,102,70);
    padding: 4px !important;
}

.whatsdone-table td {
    font-size: 15px;
    vertical-align: bottom;
    border: none !important;
    overflow: hidden;
    padding: 4px !important;
    text-overflow: ellipsis;
}

.whatsdone-table td .all-tasks {
    display: block;
    overflow: hidden;
    width: 100%;
    white-space: nowrap;
    text-overflow: ellipsis;
}
</style>
