<style></style>

<template>
    <video :src="videoSrc"
           @canplaythrough="canPlay"
           @ended="videoEnded"
           muted playsinline preload
    ></video>
</template>

<script type="text/babel">
    export default {

        props: ['video-src'],

        data() {
            return {

            }
        },

        ready() {
            this.$el.load();
        },

        methods: {

            logEvent(event) {
                console.log(event);
            },

            canPlay() {
                this.$parent.canShow();
            },

            pause() {
                this.$el.pause();
            },

            play() {
                this.$el.play();
            },

            videoEnded() {
                this.$emit('videoended');
            }

        }
    }
</script>