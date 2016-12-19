<style></style>

<template>
    <div class="new-until-switch-component">
        <p class="lead">{{ component_status }}</p>
        <div class="days-edit-section">
            <button class="btn dd-btn btn-clear-danger" v-show="is_new" v-on:click="markAsOld">
                <span v-show="!saving">Clear</span>
                <div class="spinner" v-show="saving">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </button>
            <button class="btn dd-btn btn-light" v-on:click="modalOpen = true">
                {{ is_new ? 'Edit' : 'Mark New' }}
            </button>
            <modal :show.sync="modalOpen">
                <div slot="header">
                    <h3>Select the number of days this should be new for</h3>
                </div>
                <div slot="body">
                    <p class="lead text-center">{{ desired_days }}</p>
                    <input type="range" min="1" max="90" step="1" v-model="desired_days">
                </div>
                <div slot="footer">
                    <button class="btn dd-btn btn-grey"
                            @click="modalOpen = false">
                        Cancel
                    </button>
                    <button class="btn dd-btn btn-dark" @click="setDate">
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
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['initially-new', 'product-id', 'initial-days'],

        data() {
            return {
                desired_days: 90,
                days_new: null,
                modalOpen: false,
                is_new: null,
                saving: false
            }
        },

        computed: {

            component_status() {
                if (this.is_new) {
                    return 'This product is marked as new for the next ' + this.days_new + ' day' + (this.days_new > 1 ? 's.' : '.');
                }

                return 'This product is currently not marked as new.';
            }

        },

        ready() {
            this.is_new = this.initiallyNew;
            this.days_new = this.initialDays;
        },

        methods: {

            setDate() {
                this.saving = true;
                this.sendPayload({'new': true, days: this.desired_days});
            },

            sendPayload(payload) {
                this.$http.post('/admin/products/' + this.productId + '/markednew', payload)
                        .then((res) => this.onSuccess(res.data))
                        .catch((err) => this.onFailure());
            },

            onSuccess(res) {
                this.modalOpen = false;
                this.is_new = res.new_state;
                this.days_new = res.days_new;
                this.saving = false;
            },

            onFailure() {
                this.modalOpen = false;
                this.$dispatch('user-alert', {
                    type: 'error',
                    title: 'Oops! An Error!',
                    text: 'There was an error while trying to sync the data. Maybe refresh the page and try again.',
                    confirm: true
                });
            },

            markAsOld() {
                this.sendPayload({'new': false});
            }
        }

    };
</script>