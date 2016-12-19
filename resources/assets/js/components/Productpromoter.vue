<style></style>

<template>
    <div class="product-promoter-container" style="padding-bottom: 30px;">
        <p class="lead">Promote this product?</p>
        <p class="text-uppercase h6">{{ title }}</p>
        <div class="promotion-actions">
            <button class="btn dd-btn btn-grey" v-show="is_promoted" @click="demote">Clear</button>
            <button class="btn dd-btn" @click="modalOpen = true">{{ promoteButtonText }}</button>
        </div>
        <modal :show.sync="modalOpen">
            <div slot="header">Select a date to promote until</div>
            <div slot="body">
                <input type="date" v-model="promote_until">
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-grey"
                        @click="modalOpen = false">
                    Cancel
                </button>
                <button class="btn dd-btn btn-dark" @click="promote">
                    <span v-show="!saving">Set Date</span>
                    <div class="spinner" v-show="saving">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </button>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: ['initial-date', 'initial-state', 'product-id'],

        data() {
            return {
                saving: false,
                promote_until: null,
                modalOpen: false,
                is_promoted: null,
                last_confirmed_date: null,
            };
        },

        computed: {
            promoteButtonText() {
                return this.is_promoted ? 'Reset Date' : 'Promote';
            },

            title() {
                return this.is_promoted ? 'This product is promoted until ' + this.last_confirmed_date : 'Click below to set a date to promote until';
            }
        },

        ready() {
            this.promote_until = this.initialDate;
            this.is_promoted = this.initialState;
            this.last_confirmed_date = this.initialDate;
        },

        methods: {

            promote() {
                this.saving = true;
                this.$http.post('/admin/products/' + this.productId + '/promote', {promote: true, promote_until: this.promote_until})
                        .then((res) => this.onSuccess(res.data.new_state))
                        .catch((err) => this.onFailure());
            },

            demote() {
                this.$http.post('/admin/products/' + this.productId + '/promote', {promote: false})
                        .then((res) => this.onSuccess(res.data.new_state))
                        .catch((err) => this.onFailure());
            },

            onSuccess(promoted) {
                this.is_promoted = promoted;
                this.saving = false;
                this.modalOpen = false;
                this.last_confirmed_date = this.promote_until
            },

            onFailure() {
                this.$dispatch('user-alert', {
                    type: 'error',
                    title: 'Sorry, there was a problem',
                    text: 'Unable to save your changes. Please refresh and try again. Thanks.'
                });
                this.saving = false;
                this.modalOpen = false;
                this.promote_until = this.last_confirmed_date;
            }
        }
    }
</script>