<style></style>

<template>
    <div class="sharing-summary">
        <span class="lead summary-text">{{ summary_text }}</span>
        <div class="icons">
            <div class="icon-holder facebook" :class="{'sharing': facebookReady}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52.32 52.32">
                    <path class="colour-in" fill="#ffffff"
                          d="M21.42 21.84h2.64v-2.56c0-1.13 0-2.87.85-4A4.69 4.69 0 0 1 29 13.41a16.57 16.57 0 0 1 4.73.48l-.66 3.91a8.9 8.9 0 0 0-2.12-.32c-1 0-1.94.37-1.94 1.39v3h4.21l-.29 3.82H29v13.23h-4.94V25.66h-2.64z"/>
                </svg>
            </div>
            <div class="icon-holder twitter" :class="{'sharing': twitterReady}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52.32 52.32">
                    <path class="colour-in" fill="#ffffff"
                          d="M38.94,18.24a10.46,10.46,0,0,1-3,.83,5.25,5.25,0,0,0,2.31-2.9,10.48,10.48,0,0,1-3.33,1.27A5.25,5.25,0,0,0,26,22.21a14.88,14.88,0,0,1-10.81-5.48,5.25,5.25,0,0,0,1.62,7,5.23,5.23,0,0,1-2.37-.66v.07a5.24,5.24,0,0,0,4.21,5.14,5.28,5.28,0,0,1-2.37.09A5.24,5.24,0,0,0,21.15,32a10.59,10.59,0,0,1-7.76,2.17,14.91,14.91,0,0,0,23-12.56c0-.23,0-.45,0-.68a10.63,10.63,0,0,0,2.62-2.71"/>
                </svg>
            </div>
            <div class="icon-holder googleplus" :class="{'sharing': googlePlusReady}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 134.658 131.646">
                    <!--<path fill="#DC4A38" d="M126.515,4.109H8.144c-2.177,0-3.94,1.763-3.94,3.938v115.546c0,2.179,1.763,3.942,3.94,3.942h118.371-->
		<!--c2.177,0,3.94-1.764,3.94-3.942V8.048C130.455,5.872,128.691,4.109,126.515,4.109z"/>-->
                    <path fill="#FFFFFF" d="M70.479,71.845l-3.983-3.093c-1.213-1.006-2.872-2.334-2.872-4.765c0-2.441,1.659-3.993,3.099-5.43
			c4.64-3.652,9.276-7.539,9.276-15.73c0-8.423-5.3-12.854-7.84-14.956h6.849l7.189-4.517H60.418
			c-5.976,0-14.588,1.414-20.893,6.619c-4.752,4.1-7.07,9.753-7.07,14.842c0,8.639,6.633,17.396,18.346,17.396
			c1.106,0,2.316-0.109,3.534-0.222c-0.547,1.331-1.1,2.439-1.1,4.32c0,3.431,1.763,5.535,3.317,7.528
			c-4.977,0.342-14.268,0.893-21.117,5.103c-6.523,3.879-8.508,9.525-8.508,13.51c0,8.202,7.731,15.842,23.762,15.842
			c19.01,0,29.074-10.519,29.074-20.932C79.764,79.709,75.344,75.943,70.479,71.845z M56,59.107
			c-9.51,0-13.818-12.294-13.818-19.712c0-2.888,0.547-5.87,2.428-8.199c1.773-2.218,4.861-3.657,7.744-3.657
			c9.168,0,13.923,12.404,13.923,20.382c0,1.996-0.22,5.533-2.762,8.09C61.737,57.785,58.762,59.107,56,59.107z M56.109,103.65
			c-11.826,0-19.452-5.657-19.452-13.523c0-7.864,7.071-10.524,9.504-11.405c4.64-1.561,10.611-1.779,11.607-1.779
			c1.105,0,1.658,0,2.538,0.111c8.407,5.983,12.056,8.965,12.056,14.629C72.362,98.542,66.723,103.65,56.109,103.65z"/>
                    <polygon fill="#FFFFFF" points="98.393,58.938 98.393,47.863 92.923,47.863 92.923,58.938 81.866,58.938 81.866,64.469
			92.923,64.469 92.923,75.612 98.393,75.612 98.393,64.469 109.506,64.469 109.506,58.938 		"/>
                </svg>

            </div>
        </div>

        <a href="/admin/social" class="btn dd-btn btn-light">Edit</a>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        data() {
            return {
                facebookReady: false,
                twitterReady: false,
                googlePlusReady: false
            };
        },

        computed: {
            summary_text() {
                if (this.facebookReady || this.twitterReady || this.googlePlusReady) {
                    return 'New posts are automatically shared with:';
                }

                return 'New posts are not currently being shared with any social network.';
            }
        },

        ready() {
            this.fetchFacebook();
            this.fetchTwitter();
            this.fetchGooglePlus();
        },

        methods: {
            fetchFacebook() {
                this.$http.get('/admin/social/facebook/user')
                        .then((res) => this.checkFacebook(res.json()))
                        .catch((er) => console.log(er));
            },

            checkFacebook(facebook) {
                if (facebook.authorised && facebook.user.share) {
                    this.facebookReady = true;
                }
            },

            fetchTwitter() {
                this.$http.get('/admin/social/twitter/user')
                        .then((res) => this.checkTwitter(res.json()))
                        .catch((er) => console.log(er));
            },

            checkTwitter(twitter) {
                if (twitter.authorised && twitter.user.share) {
                    this.twitterReady = true;
                }
            },

            fetchGooglePlus() {
                this.$http.get('/admin/social/googleplus/user')
                        .then((res) => this.checkGooglePlus(res.json()))
                        .catch((er) => console.log(er));
            },

            checkGooglePlus(googlePlus) {
                if (googlePlus.authorised && googlePlus.user.share) {
                    this.googlePlusReady = true;
                }
            }
        }
    };
</script>