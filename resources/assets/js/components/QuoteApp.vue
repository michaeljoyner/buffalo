<style></style>

<template>
    <div class="quote-ap-container">
        <section class="dd-page-header clearfix">
            <h1 class="pull-left">#{{ quote_number }}</h1>
            <div class="header-actions pull-right">
                <a :href="`/admin/quotes/${quoteId}`" class="btn dd-btn btn-light">Back</a>
                <button class="dd-btn btn btn-dark" @click="openAddModal">Add Item</button>
            </div>
        </section>
        <section class="quote-app-items">
            <quote-item v-for="item in items" :key="item.id"
                        :initial-props="item"
                        @remove-quoteitem="removeItem"
            ></quote-item>
        </section>
        <quote-item-add :quote-id="quoteId" @add-to-quote="fetchItems"></quote-item-add>
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

        mounted() {
          this.fetchItems();
        },

        methods: {
            openAddModal() {
                eventHub.$emit('add-quote-item');
            },

            fetchItems() {
                axios.get(`/admin/quotes/${this.quoteId}/items`)
                        .then(({data}) => this.items = data)
                        .catch(err => console.log(err));
            },

            removeItem({id}) {
                const item = this.items.find(item => item.id === id);

                this.items.splice(this.items.indexOf(item), 1);
            }
        }
    }
</script>