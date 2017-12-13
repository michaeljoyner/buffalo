<style></style>

<template>
    <span class="delete-button-component">
        <button class="btn dd-btn btn-solid-danger" @click="showDeleteModal = true">Delete</button>
        <modal :show="showDeleteModal" :wider="false">
            <div slot="header">
                <h3>Are You Sure?</h3>
            </div>
            <div slot="body">
                <p class="lead">{{ message }}</p>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-grey"
                        @click="showDeleteModal = false">
                    Cancel
                </button>
                <button class="btn dd-btn btn-solid-danger"
                        @click="doDelete"
                >
                    <span v-show="! deleting">Yes! Delete it.</span>
                    <div class="spinner" v-show="deleting">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </button>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {
        props: ['message', 'delete-url'],

        data() {
            return {
                showDeleteModal: false,
                deleting: false
            };
        },

        methods: {

            doDelete() {
                axios.delete(this.deleteUrl)
                        .then(() => this.onSuccess())
                        .catch((err) => this.onFail(err));
            },

            onSuccess() {
                this.deleting = false;
                this.showDeleteModal = false;
                this.$emit('item-deleted');
            },

            onFail(err) {
                this.showDeleteModal = false;
                eventHub.$emit('error-alert', 'Unable to delete the resource at the moment. Please refresh and try again');
                this.deleting = false;
            }
        }
    }
</script>