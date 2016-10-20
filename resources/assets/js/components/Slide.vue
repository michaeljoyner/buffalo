<style></style>

<template>
    <div class="carousel-slide" :class="textColour" transition="slide">
        <div class="media-aspect-box">
            <img @load="canShow" :src="imageSrc" :alt="slideText" v-if="!isVideo">
            <video-slide v-ref:vid v-if="isVideo" :video-src="'/videos/' + video"></video-slide>
        </div>
        <span class="slide-text">{{ slideText }}</span>
        <a v-if="actionLink && actionText" href="{{ actionLink }}" class="slide-action">{{
            actionText }}</a>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: ['slide-text', 'action-link', 'action-text', 'text-colour', 'is-video', 'video', 'image-src', 'slide-index'],

        data() {
            return {
                readyToShow: false
            };
        },

        events: {
            'now-leaving': function(index) {
                if(index === this.slideIndex) {
                    this.onLeaving();
                }
            },

            'now-showing': function(index) {
                if(index === this.slideIndex) {
                    this.onShow();
                }
            }
        },

        methods: {
            canShow() {
                console.log('slide ' + this.slideIndex + ' is ready to show');
                this.readyToShow = true;
                this.$parent.markAsReady(this.slideIndex);
            },

            onLeaving() {
                if(this.isVideo) {
                    this.$refs.vid.pause();
                }
            },

            onShow() {
                if(this.isVideo) {
                    this.$refs.vid.play();
                }
            }
        }
    }
</script>