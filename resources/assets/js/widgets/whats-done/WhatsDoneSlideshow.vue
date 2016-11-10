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
                console.log(nextUser.id);

                this.showUser = nextUser.id;

                // this.carousel = new Slick($('.slideshow')[9], {
                //     infinite: true,
                //     slidesToShow: 1,
                //     slidesToScroll: 1
                // });

                // if ( ! this.flkty) {
                //     this.flkty = new Flickity(document.querySelector('.slideshow'), {
                //         autoPlay: 2000,
                //         // prevNextButtons: false,
                //         pageDots: false,
                //     });
                // } else {
                //     this.flkty.prepend( $('<div class="slide"><div class="cont"><h5>Boris Strahija</h5> <div class="tasks"><span><span>OptimizeLeads - CDN fix, dev test and setup, </span></span></div></div></div>') );
                //     this.flkty.reloadCells();
                //     console.log(this.flkty.cells.length);
                // }
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
