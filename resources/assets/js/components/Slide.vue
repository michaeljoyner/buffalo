<style></style>

<template>
    <div class="carousel-slide" :class="textColour" :transition="direction">
        <div class="media-aspect-box">
            <picture v-if="!isVideo">
                <source :srcset="imageSrc" media="(min-width: 720px)">
                <source :srcset="smallImgSrc" media="(max-width: 719px)">
                <img @load="canShow" :src="imageSrc" :alt="slideText">
            </picture>
            <!--<img @load="canShow" :src="imageSrc" :alt="slideText" v-if="!isVideo">-->
            <video-slide v-ref:vid v-if="isVideo" :video-src="'/videos/' + video" @videoended="endOfVideo"></video-slide>
        </div>
        <span class="slide-text">{{ slideText }}</span>
        <a v-if="actionLink && actionText" href="{{ actionLink }}" class="slide-action">{{
            actionText }}</a>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: ['slide-text', 'action-link', 'action-text', 'text-colour', 'is-video', 'video', 'image-src', 'small-img-src', 'slide-index'],

        data() {
            return {
                virgin: false
            };
        },

        computed: {
            direction() {
                return this.$parent.direction;
            }
        },

        events: {
            'now-leaving': function (index) {
                if (index === this.slideIndex) {
                    this.onLeaving();
                }
            },

            'now-showing': function (index) {
                if (index === this.slideIndex) {
                    this.onShow();
                }
            }
        },

        methods: {
            canShow() {
                if(! this.virgin) {
                    this.virgin = true;
                    this.$parent.markAsReady(this.slideIndex);
                }
            },

            onLeaving() {
                if (this.isVideo) {
//                    this.$refs.vid.pause();
                }
            },

            onShow() {

                if (this.isVideo) {
                    this.$refs.vid.currentTime = 0;
                    return this.$refs.vid.play();
                }

                window.setTimeout(() => this.$dispatch('requestnext', this.slideIndex), this.$parent.slideTime);
            },

            endOfVideo() {
                window.setTimeout(() => this.$dispatch('requestnext', this.slideIndex), 500);
            }
        }
    }
</script>