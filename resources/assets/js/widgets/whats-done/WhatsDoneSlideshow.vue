<template src="./WhatsDoneSlideshow.html"></template>

<script>
export default {
    data () {
        return {
            updateInterval       : false,
            updateIntervalLength : 8000,
            users                : [],
            showUser             : false,
        }
    },

    methods: {
        fetchUsers() {
            $.getJSON('/api/whatsdone', (users) => {
                this.users = users;

                // Get random user
                let nextUser = users[Math.floor(Math.random() * users.length)];

                this.showUser = nextUser.id;
            }).fail(() => {
                this.users = [];
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

<style src="./WhatsDone.scss" lang="sass"></style>
