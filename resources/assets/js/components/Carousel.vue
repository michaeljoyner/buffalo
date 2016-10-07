<style></style>

<template>
    <div class="carousel-slider" :class="{'ready': isReadyToStart}" @mouseover.stop="stop" @mouseout.stop="play">
        <div v-for="slide in slides | orderBy 'position'"
             v-show="isCurrent(slide)"
             transition="slide"
             class="carousel-slide"
             :class="[slide.text_colour]"
        >
            <img @load="markAsReady(slide, $event)" :src="slide.image_src" :alt="slide.slide_text" v-if="!slide.is_video">
            <video @canplaythrough="markAsReady(slide, $event)" :src="'/videos/' + slide.video" autoplay muted loop v-if="slide.is_video"></video>
            <span class="slide-text">{{ slide.slide_text }}</span>
            <a v-if="slide.action_link && slide.action_text" href="{{ slide.action_link }}" class="slide-action">{{
                slide.action_text }}</a>
        </div>
        <span v-show="readyCount > 1" class="carousel-prev-arrow carousel-nav-arrow" @click="prevSlide">&lt;</span>
        <span v-show="readyCount > 1" class="carousel-next-arrow carousel-nav-arrow" @click="nextSlide">&gt;</span>
        <div class="carousel-dot-nav" v-show="readyCount > 1">
            <div class="carousel-dot"
                 v-for="slide in readySlides"
                 @click="setCurrentImg(slide)"
            ></div>
        </div>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: ['auto-play', 'slide-time'],

        data() {
            return {
                slides: [],
                currentImg: 0,
                readyCount: 0,
                interval: null
            }
        },

        computed: {

            readySlides() {
                return this.slides.filter((slide) => slide.is_ready);
            },

            isReadyToStart() {
                return this.readyCount > 1 && this.slides[0].is_ready;
            }
        },

        ready() {
            this.fetchSlides();
        },

        methods: {

            fetchSlides() {
                this.$http.get('/api/slides')
                        .then((res) => this.$set('slides', res.data))
                        .catch(() => console.log('error fetching slides'));
            },

            isCurrent(slide) {
                if(this.currentImg === null) {
                    return false;
                }
                return (slide.id === this.slides[this.currentImg].id) && slide.is_ready;
            },

            setCurrentImg(slide) {
                this.currentImg = this.slides.findIndex((s) => s.id === slide.id);
            },
            
            nextSlide() {
                let nextIndex = this.nextInLine(this.currentImg);

                while(! this.slides[nextIndex].is_ready) {
                    nextIndex = this.nextInLine(nextIndex);
                }

                return this.currentImg = nextIndex;
            },

            nextInLine(current) {
                return current == this.slides.length - 1 ? 0 : current += 1;
            },

            prevInLine(current) {
              return current === 0 ? this.slides.length - 1 : current -+ 1;
            },
            
            prevSlide() {
                let nextIndex = this.prevInLine(this.currentImg);

                while(! this.slides[nextIndex].is_ready) {
                    nextIndex = this.prevInLine(nextIndex);
                }

                return this.currentImg = nextIndex;
                return this.currentImg--;
            },

            markAsReady(slide) {
                slide.is_ready = true;
                this.readyCount++;
                if(this.shouldPlay()) {
                    this.play();
                }
            },

            isReady(slide) {
                return slide.is_ready;
            },

            play() {
                this.interval = setInterval(() => this.nextSlide(), this.slideTime);
            },

            stop() {
                clearInterval(this.interval);
                this.interval = null;
            },

            shouldPlay() {
                return this.isReadyToStart && (this.interval === null) && this.autoPlay;
            }
        }
    }
</script>