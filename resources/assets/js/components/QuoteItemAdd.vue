<style></style>

<template>
    <span class="quote-item-add-component">
        <modal :show.sync="open" :wider="true" :fixed="true">
            <div slot="header">
                <h3>Add Products To Quote</h3>
            </div>
            <div slot="body">
                <div class="product-search">
                    <type-ahead live-search-url="/admin/api/products/search"
                                v-on:typeahead-selected="setProduct"
                                :clear-on-hit="true"
                                :search-fields='["factory_number", "product_code"]'
                    ></type-ahead>
                </div>
                <div class="selected-products">
                    <h4 class="text-center" v-show="selected_products.length">Products to Add</h4>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="product in selected_products">{{ product.name }}</li>
                    </ul>
                </div>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-light"
                        v-show="selected_products.length"
                        @click="resetSelections">
                    Reset
                </button>
                <button class="btn dd-btn btn-grey"
                        @click="open = false">
                    Cancel
                </button>
                <button class="btn dd-btn btn-dark"
                        :disabled="selected_products.length === 0"
                        @click="addItemsToQuote"
                >
                    Add Items
                </button>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {

        props: ['quote-id'],

        data() {
            return {
                open: false,
                selected_products: []
            }
        },

        events: {
            'add-item': function () {
                this.open = true;
            }
        },

        methods: {

            setProduct(product) {
                this.selected_products.push(product);
            },

            addItemsToQuote() {
                const ids = this.selected_products.map(product => product.id);
                this.$http.post('/admin/quotes/' + this.quoteId + '/items', { product_ids: ids })
                        .then(() => this.onSuccess())
                        .catch(err => console.log(err));
            },

            onSuccess() {
                this.resetSelections();
                this.$dispatch('add-to-quote', {});
                this.open = false;
            },

            resetSelections() {
                this.selected_products = [];
            }
        }
    }
</script>