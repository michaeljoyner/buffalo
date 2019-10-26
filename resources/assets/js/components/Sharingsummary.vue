<style></style>

<template>
    <div class="sharing-summary">
        <span class="lead summary-text">{{ summary_text }}</span>
        <div class="icons">
            <div class="icon-holder facebook" :class="{'sharing': fbShare}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52.32 52.32">
                    <path class="colour-in" fill="#ffffff"
                          d="M21.42 21.84h2.64v-2.56c0-1.13 0-2.87.85-4A4.69 4.69 0 0 1 29 13.41a16.57 16.57 0 0 1 4.73.48l-.66 3.91a8.9 8.9 0 0 0-2.12-.32c-1 0-1.94.37-1.94 1.39v3h4.21l-.29 3.82H29v13.23h-4.94V25.66h-2.64z"/>
                </svg>
            </div>
            <div class="icon-holder twitter" :class="{'sharing': twShare}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52.32 52.32">
                    <path class="colour-in" fill="#ffffff"
                          d="M38.94,18.24a10.46,10.46,0,0,1-3,.83,5.25,5.25,0,0,0,2.31-2.9,10.48,10.48,0,0,1-3.33,1.27A5.25,5.25,0,0,0,26,22.21a14.88,14.88,0,0,1-10.81-5.48,5.25,5.25,0,0,0,1.62,7,5.23,5.23,0,0,1-2.37-.66v.07a5.24,5.24,0,0,0,4.21,5.14,5.28,5.28,0,0,1-2.37.09A5.24,5.24,0,0,0,21.15,32a10.59,10.59,0,0,1-7.76,2.17,14.91,14.91,0,0,0,23-12.56c0-.23,0-.45,0-.68a10.63,10.63,0,0,0,2.62-2.71"/>
                </svg>
            </div>

        </div>

        <a href="/admin/social" class="btn dd-btn btn-light">Edit</a>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['fb-share', 'tw-share'],

        computed: {
            summary_text() {
                if (this.fbShare || this.twShare) {
                    return 'New posts are automatically shared with:';
                }

                return 'New posts are not currently being shared with any social network.';
            }
        },
    };
</script>