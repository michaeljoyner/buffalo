<style></style>

<template>
    <div class="sortable-container">
        <div class="saving-indicator dd-btn btn btn-dark" style="width: 10em;">
            <span v-show="!syncing">Synced</span>
            <div class="spinner" v-show="syncing">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="slides-index sortable-list" v-el:sortlist>
            <slot>
                <h3>There are no items to sort</h3>
            </slot>
        </div>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: ['sort-url'],

        data() {
            return {
                sorts: null,
                syncing: false,
            }
        },

        ready() {
            this.sorts = new Sortable(this.$els.sortlist, {onSort: this.onSort});
        },

        methods: {
            onSort: function () {
                this.syncing = true;
                this.$http.post(this.sortUrl, {order: this.sorts.toArray()})
                        .then(() => this.syncing = false)
                        .catch(() => this.onFailedSync());
            },

            onFailedSync() {
                this.syncing = false;
                this.$dispatch('user-alert', {
                    title: 'Oops, an error occurred!',
                    text: 'There was a problem syncing with the server. Maybe refresh the page and try again',
                    confirm: true,
                    type: 'error'
                });
            }
        }
    }
</script>