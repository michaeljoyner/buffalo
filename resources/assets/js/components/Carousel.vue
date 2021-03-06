<style></style>

<template>
    <div class="carousel-slider"
         :class="{'ready': isReadyToStart}"
         @mouseenter.stop="stop"
         @mouseleave.stop="play">
        <banner-slide v-for="(slide, index) in ordered_slides"
                      :key="slide.id"
                      :text-colour="slide.text_colour"
                      :slide-text="slide.slide_text"
                      :action-text="slide.action_text"
                      :action-link="slide.action_link"
                      :is-video="slide.is_video"
                      :image-src="slide.image_src"
                      :small-img-src="slide.small_image"
                      :video="slide.video"
                      :slide-index="index"
                      v-show="index == currentImg"
                      :direction="direction"
                      @requestnext="onRequestNext"
        ></banner-slide>

        <img src="/images/slider_arrow.png"
             v-show="readyCount > 1"
             class="carousel-prev-arrow carousel-nav-arrow"
             @click="prevSlide">
        <img src="/images/slider_arrow.png"
             v-show="readyCount > 1"
             class="carousel-next-arrow carousel-nav-arrow"
             @click="nextSlide">
        <div class="carousel-dot-nav"
             v-show="readyCount > 1">
            <div class="carousel-dot"
                 v-for="slide in readySlides"
                 :key="slide.id"
                 @click="setCurrentImg(slide)"
            ></div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['auto-play', 'slide-time'],

        data() {
            return {
                slides: [],
                currentImg: 0,
                readyCount: 0,
                interval: null,
                reloaded: false,
                direction: 'slide'
            }
        },

        computed: {
            readySlides() {
                return this.slides.filter((slide) => slide.is_ready);
            },

            isReadyToStart() {
                return this.readyCount > 1 && this.slides[0].is_ready;
            },

            ordered_slides() {
                return this.slides.sort((a, b) => b.position - a.position);
            }
        },

        mounted() {
            this.fetchSlides();
        },

        methods: {

            fetchSlides() {
                axios.get('/api/slides')
                     .then(({data}) => this.slides = data)
                     .catch(() => console.log('error fetching slides'));
            },

            isCurrent(slide) {
                if (this.currentImg === null) {
                    return false;
                }
                return (slide.id === this.slides[this.currentImg].id) && slide.is_ready;
            },

            setCurrentImg(slide) {
                this.currentImg = this.slides.findIndex((s) => s.id === slide.id);
            },

            nextSlide() {
                this.direction = 'slide';
                this.$nextTick(() => this.changeSlide(this.nextInLine));
            },

            prevSlide() {
                this.direction = 'slide-right';
                this.$nextTick(() => this.changeSlide(this.prevInLine));
            },

            nextInLine(current, listLength) {
                return current === listLength - 1 ? 0 : current + 1;
            },

            prevInLine(current, listLength) {
                return current === 0 ? listLength - 1 : current - 1;
            },

            changeSlide(nextIndex) {
                eventHub.$emit('slide-now-leaving', this.currentImg);
                let next = nextIndex(this.currentImg, this.slides.length);

                while (!this.slides[next].is_ready) {
                    next = nextIndex(next, this.slides.length);
                }

                this.currentImg = next;
                eventHub.$emit('slide-now-showing', this.currentImg);
            },

            markAsReady(slideIndex) {
                let slide = this.slides[slideIndex];
                slide.is_ready = true;
                this.readyCount++;

                if (this.isReadyToStart) {
                    this.removeOriginal();
                }

                if (this.shouldPlay()) {
                    this.play();
                }
            },

            isReady(slide) {
                return slide.is_ready;
            },

            play() {
                if (!this.autoPlay || this.interval) {
                    return;
                }
                this.interval = setTimeout(() => this.nextSlide(), this.slideTime);
            },

            stop() {
                clearInterval(this.interval);
                this.interval = null;
            },

            shouldPlay() {
                return this.isReadyToStart && (this.interval === null) && this.autoPlay;
            },

            removeOriginal() {
                setTimeout(() => document.querySelector('.original-slide').style.display = "none", 1500);
            },

            onRequestNext(requesterIndex) {
                if (requesterIndex === this.currentImg && this.interval) {
                    this.nextSlide();
                }
            }
        }
    }
</script>