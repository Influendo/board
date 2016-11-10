<template src="./WhatsDone.html"></template>

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

<style src="./WhatsDone.scss"></style>
