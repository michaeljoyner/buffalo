<style></style>

<template>
    <div class="publish-button-box">
        <button class="btn dd-btn btn-dark" v-on:click="handleClick">
            <span v-show="!syncing">{{ buttonText }}</span>
            <div class="spinner" v-show="syncing">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </button>
        <modal :show.sync="showModal">
            <div slot="header">
                <h3>Ready to publish</h3>
            </div>
            <div slot="body">
                <p class="lead">You are about to publish this article for the first time, which will automatically share to social media. This only happens this once, so now is a good time to check if the article is complete and has a featured image.</p>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-grey"
                        @click="showModal = false">
                    Cancel
                </button>
                <button class="btn dd-btn btn-dark" @click="pushState">
                    Publish
                </button>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: ['url', 'published', 'virgin'],

        data() {
            return {
                showModal: false,
                syncing: false
            }
        },

        computed: {
            buttonText() {
                if(this.virgin) {
                    return this.published ? 'Retract' : 'Publish';
                }

                return this.published ? 'Retract' : 'Re-publish';
            }
        },

        methods: {
            handleClick() {
                if(this.virgin) {
                   return this.showModal = true;
                }

                this.pushState();
            },

            pushState() {
                this.showModal = false;
                this.syncing = true;
                this.$http.post(this.url, {publish: !this.published})
                        .then((res) => this.onSuccess(res))
                        .catch((res) => this.onFail());
                this.virgin = false;
            },

            onSuccess(res) {
              this.published = res.body.new_state;
                this.syncing = false;
            },

            onFail(res) {
                this.$dispatch('user-alert', {
                    type: 'error',
                    title: 'Sorry, there was a problem',
                    text: 'Unable to save new published state. Please refresh and try again. Thanks.'
                });
                this.syncing = false;
            }
        }
    }
</script>