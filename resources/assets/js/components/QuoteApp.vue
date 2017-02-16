<style></style>

<template>
    <div class="quote-ap-container">
        <section class="dd-page-header clearfix">
            <h1 class="pull-left">#{{ quote_number }}</h1>
            <div class="header-actions pull-right">
                <a :href="'/admin/quotes/' + quoteId" class="btn dd-btn btn-light">Back</a>
                <button class="dd-btn btn btn-dark" @click="openAddModal">Add Item</button>
            </div>
        </section>
        <section class="quote-app-items">
            <!--<quote-item v-for="item in items"></quote-item>-->
        </section>
        <quote-item-add v-on:ad-to-quote="addNewItem"></quote-item-add>
    </div>

</template>

<script type="text/babel">
    export default {
        props: ['quote-id', 'quote_number'],

        data() {
            return {
                items: []
            };
        },

        methods: {
            openAddModal() {
                this.$broadcast('add-item');
            },

            addNewItem() {

            }
        }
    }
</script>