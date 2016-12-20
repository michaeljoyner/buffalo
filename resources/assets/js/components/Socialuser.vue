<style></style>

<template>
    <div class="social-user-card {{ platform }}">
        <div v-show="authorised" class="user-details">
            <img :src="user.cover_src" alt="">
            <h3 class="user-name">{{ user.name }}</h3>
        </div>
        <div v-show="!authorised" class="no-user-card">
            <p class="lead">Not currently authorised. Click below to get permission.</p>
        </div>
        <div class="actions">
            <span>Auto share news? </span>
            <toggle-switch :identifier="unique"
                           true-label="yes"
                           false-label="no"
                           :current-status.sync="user.share"
                           :toggle-url="'/admin/social/' + this.platform + '/user/' + this.user.id + '/share'"
                           toggle-attribute="share"
            ></toggle-switch>
            <a href="/admin/{{ platform }}/login" class="btn dd-btn btn-light">{{ buttonText }}</a>
        </div>
        <div v-show="!ready" class="loading-card" transition="fade">
            <img :src="iconSrc" alt="">
        </div>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: ['fetch-url', 'platform', 'icon-src', 'unique'],

        data() {
            return {
                user: {
                    name: '',
                    cover_src: '',
                    share: false,
                    id: ''
                },
                authorised: null,
                ready: false
            }
        },

        computed: {
            buttonText() {
                return this.authorised ? 'Change Profile' : 'Get Permission';
            }
        },

        ready() {
            this.getData();
        },

        methods: {

            getData() {
                this.$http.get(this.fetchUrl)
                        .then((res) => this.onSuccess(res))
                        .catch((err) => this.onFail(err));
            },

            onSuccess(res) {
                const data = res.body;
                this.user.name = data.user.name;
                this.user.cover_src = data.user.cover_src;
                this.user.id = data.user.id;
                this.user.share = data.user.share;
                this.authorised = data.authorised;
                this.ready = true;
            },

            onFail() {
                this.authorised = false;
                this.ready = true;
            }
        }
    }
</script>