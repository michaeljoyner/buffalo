<style></style>

<template>
    <video :src="videoSrc"
           @canplaythrough="canPlay"
           muted playsinline preload loop
           @error="logEvent('error')"
           @progress="logEvent('progress')"
           @loadstart="logEvent('loadstart')"
    ></video>
</template>

<script type="text/babel">
    module.exports = {

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
            }

        }
    }
</script>