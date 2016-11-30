<template src="./Nisam.html"></template>

<style src="./Nisam.scss" lang="sass"></style>

<script>

export default {

    extends: window._widget,

    data() {
        return {
            url: "/api/nisam",
            response: {
                data: null,
                error: null
            }
        };
    },

    methods: {
        getVotes() {
            let result = [];

            this.response.data.votes.forEach((value) => {
                if (value.votes) {
                    result.push(value);
                }
            });

            result.sort((a,b) => {
                if (a.votes < b.votes) return +1;
                if (a.votes > b.votes) return -1;
                //if (a.name  < b.name)  return +1;
                //if (a.name  > b.name)  return -1;
                if (a.name.localeCompare(b.name)) return a.name.localeCompare(b.name);
                if (a.id    < b.id)    return +1;
                if (a.id    > b.id)    return -1;

                return 0;
            });

            return result;
        }
    }

}

</script>
