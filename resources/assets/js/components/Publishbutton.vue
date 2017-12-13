<style></style>

<template>
    <div class="publish-button-box">
        <button class="btn dd-btn btn-dark" @click="handleClick">
            <span v-show="!syncing">{{ buttonText }}</span>
            <div class="spinner" v-show="syncing">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </button>
        <modal :show="showModal">
            <div slot="header">
                <h3>Ready to publish</h3>
            </div>
            <div slot="body">
                <p class="lead">You are about to publish this article for the first time, which will automatically share to the social media, such as <span class="facebook-name">Facebook</span>, if you have it enabled. This only happens this once, so now is a good time to check if the article is complete and has a featured image.</p>
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
    export default {

        props: ['url', 'published', 'virgin'],

        data() {
            return {
                is_published: this.published,
                showModal: false,
                syncing: false,
                is_virgin: this.virgin
            }
        },

        computed: {
            buttonText() {
                if(this.virgin) {
                    return this.is_published ? 'Retract' : 'Publish';
                }

                return this.is_published ? 'Retract' : 'Re-publish';
            }
        },

        methods: {
            handleClick() {
                if(this.is_virgin) {
                   return this.showModal = true;
                }

                this.pushState();
            },

            pushState() {
                this.showModal = false;
                this.syncing = true;
                axios.post(this.url, {publish: !this.is_published})
                        .then(({data}) => this.onSuccess(data))
                        .catch((res) => this.onFail());
                this.is_virgin = false;
            },

            onSuccess(data) {
              this.is_published = data.new_state;
                this.syncing = false;
            },

            onFail(res) {
                eventHub.$emit('error-alert', 'Unable to save new published state. Please refresh and try again. Thanks.');
                this.syncing = false;
            }
        }
    }
</script>