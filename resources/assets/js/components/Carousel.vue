<style></style>

<template>
    <div class="carousel-slider" :class="{'ready': isReadyToStart}" @mouseover.stop="stop" @mouseout.stop="play">
        <banner-slide v-for="slide in slides | orderBy 'position'"
                      :text-colour="slide.text_colour"
                      :slide-text="slide.slide_text"
                      :action-text="slide.action_text"
                      :action-link="slide.action_link"
                      :is-video="slide.is_video"
                      :image-src="slide.image_src"
                      :video="slide.video"
                      :slide-index="$index"
                      v-show="$index == currentImg"
        ></banner-slide>
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
                interval: null,
                reloaded: false
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
                this.changeSlide(this.nextInLine);
            },

            prevSlide() {
                this.changeSlide(this.prevInLine);
            },

            nextInLine(current, listLength) {
                return current == listLength - 1 ? 0 : current + 1;
                console.log('forward');
            },

            prevInLine(current, listLength) {
              return current == 0 ? listLength - 1 : current - 1;
                console.log('backward');
            },

            changeSlide(nextIndex) {
                this.$broadcast('now-leaving', this.currentImg);
                let next = nextIndex(this.currentImg, this.slides.length);

                while(! this.slides[next].is_ready) {
                    next = nextIndex(next, this.slides.length);
                }

                this.currentImg = next;
                this.$broadcast('now-showing', this.currentImg);
            },

            markAsReady(slideIndex) {
                let slide = this.slides[slideIndex];
                slide.is_ready = true;
                this.readyCount++;
//                if(this.shouldPlay()) {
//                    this.play();
//                }
                if(this.isReadyToStart) {
                    this.removeOriginal();
                }
            },

            isReady(slide) {
                return slide.is_ready;
            },

            play() {
                if(! this.autoPlay) {
                    return;
                }
                this.interval = setInterval(() => this.nextSlide(), this.slideTime);
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
            }
        }
    }
</script>