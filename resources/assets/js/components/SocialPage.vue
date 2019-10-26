<template>
    <div>
        <p class="text-lg">Choose which social platforms you would like to share your posts to. Posts will only be shared the first time they are published.</p>

        <p class="warning" v-if="!fbAuth">The site currently does not have permission to post to Facebook. Click "Connect with Facebook" to get set up.</p>

        <p class="warning" v-if="!twAuth">The site currently does not have permission to post to Twitter. Click "Connect with Twitter" to get set up.</p>

        <div class="platform-card">
            <header class="facebook padded flex">
                <p><strong>Facebook</strong></p>
                <svg height="20px" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M17 1H3c-1.1 0-2 .9-2 2v14c0 1.101.9 2 2 2h7v-7H8V9.525h2v-2.05c0-2.164 1.212-3.684 3.766-3.684l1.803.002v2.605h-1.197c-.994 0-1.372.746-1.372 1.438v1.69h2.568L15 12h-2v7h4c1.1 0 2-.899 2-2V3c0-1.1-.9-2-2-2z"/></svg>
            </header>
            <div class="flex padded">
                <div class="flex">
                    <p class="px-4">Auto share:</p>
                    <simple-toggle @toggle="toggleFacebook" :status="settings.facebook.share"></simple-toggle>
                </div>
                <a href="/admin/facebook/login">Connect Account</a>
            </div>

        </div>

        <div class="platform-card">
            <header class="twitter padded flex">
                <p><strong>Twitter</strong></p>
                <svg height="20px" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M17.316 6.246c.008.162.011.326.011.488 0 4.99-3.797 10.742-10.74 10.742-2.133 0-4.116-.625-5.787-1.697a7.577 7.577 0 0 0 5.588-1.562 3.779 3.779 0 0 1-3.526-2.621 3.858 3.858 0 0 0 1.705-.065 3.779 3.779 0 0 1-3.028-3.703v-.047a3.766 3.766 0 0 0 1.71.473 3.775 3.775 0 0 1-1.168-5.041 10.716 10.716 0 0 0 7.781 3.945 3.813 3.813 0 0 1-.097-.861 3.773 3.773 0 0 1 3.774-3.773 3.77 3.77 0 0 1 2.756 1.191 7.602 7.602 0 0 0 2.397-.916 3.789 3.789 0 0 1-1.66 2.088 7.55 7.55 0 0 0 2.168-.594 7.623 7.623 0 0 1-1.884 1.953z"/></svg>
            </header>
            <div class="flex padded">
                <div class="flex">
                    <p class="px-4">Auto share:</p>
                    <simple-toggle @toggle="toggleTwitter" :status="settings.twitter.share"></simple-toggle>
                </div>
                <a href="/admin/twitter/login">Connect Account</a>
            </div>

        </div>
    </div>


</template>

<script type="text/babel">
    export default {
        props: ['fb-auth', 'tw-auth'],

        data() {
            return {
                settings: {
                    facebook: {
                        share: true,
                    },
                    twitter: {
                        share: true,
                    }
                }

            };
        },

        mounted() {
            axios.get("/admin/social-sharing")
                .then(({data}) => this.settings = data)
                .catch(console.log)
        },

        methods: {
            toggleFacebook() {
                if(this.settings.facebook.share) {
                    return this.unshareFacebook();
                }

                this.shareFacebook();
            },

            unshareFacebook() {
                axios.delete("/admin/social-sharing/facebook")
                    .then(({data}) => this.settings = data)
                    .catch(console.log);
            },

            shareFacebook() {
                axios.post("/admin/social-sharing/facebook")
                     .then(({data}) => this.settings = data)
                     .catch(console.log);
            },

            toggleTwitter() {
                if(this.settings.twitter.share) {
                    return this.unshareTwitter();
                }

                this.shareTwitter();
            },

            unshareTwitter() {
                axios.delete("/admin/social-sharing/twitter")
                     .then(({data}) => this.settings = data)
                     .catch(console.log);
            },

            shareTwitter() {
                axios.post("/admin/social-sharing/twitter")
                     .then(({data}) => this.settings = data)
                     .catch(console.log);
            }
        }

    }
</script>

<style scoped lang="css" type="text/css">
    .text-lg {
        font-size: 2rem;
    }

    .platform-card {
        max-width: 50rem;
        margin: 2rem 0;
        padding: 0;
        border: 1px solid silver;
        box-shadow: 3px 3px 3px silver;
    }

    .flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .px-4 {
        padding: 0 1rem 0 0;
    }

    .padded {
        padding: 1rem;
    }

    p {
        margin: 0;
    }

    header.facebook {
        background: #4267B2;
        color: white;
        font-size: 120%;
    }

    header.twitter {
        background: #1DA1F2;
        color: white;
        font-size: 120%;
    }

    .warning {
        color: darkred;
        font-weight: 600;
        font-size: 18px;
        margin: 2rem 0;
    }
</style>