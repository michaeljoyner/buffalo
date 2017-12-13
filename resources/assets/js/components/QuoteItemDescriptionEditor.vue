<style></style>

<template>
    <span class="quote-item-description-editor-component">
        <button @click="toggleModal" class="btn dd-btn">Edit Description</button>
        <modal :show="open" :wider="true" :fixed="true">
            <div slot="header">
                <h3>Update the description for this item</h3>
            </div>
            <div slot="body">
                <textarea :id="`qi_${itemId}_description`">{{ initialContent }}</textarea>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-grey"
                        @click="open = false">
                    Cancel
                </button>
                <button class="btn dd-btn btn-dark"
                        @click="updateDescription"
                >
                    <span v-show="! saving">Save Changes</span>
                    <div class="spinner" v-show="saving">
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

        props: ['initial-content', 'item-id'],

        data() {
            return {
                description: '',
                open: false,
                editor: null,
                saving: false
            }
        },

        mounted() {
            this.$nextTick(() => this.setUpInitial());
        },

        methods: {
            toggleModal() {
                this.open = ! this.open;
            },

            setUpInitial() {
                this.description = this.initialContent;
                tinymce.init({
                    selector: `#qi_${this.itemId}_description`,
                    plugins: ['link', 'image', 'paste', 'fullscreen', 'table'],
                    menubar: false,
                    toolbar: 'undo redo | styleselect | bold italic | bullist numlist | table link',
                    height: 300,
                    content_style: "body {font-size: 16px; max-width: 800px; margin: 0 auto; padding-top: 15px;} * {font-size: 16px;} img {opacity: .6; max-width: 100%; height: auto;} img[data-mce-src] {opacity: 1;}",
                }).then((editors) => this.editor = editors[0]);
            },

            updateDescription() {
                console.log(this.editor.getContent());
                this.saving = true;
                const description = this.editor.getContent();
                axios.patch('/admin/quoteitems/' + this.itemId, {description: description})
                        .then(({data}) => this.onUpdate(data))
                        .catch(err => this.onFail());
            },

            onUpdate() {
                this.saving = false;
                this.open = false;
            },

            onFail() {
                this.saving = false;
                this.open = false;
            }
        }
    }
</script>