<style></style>

<template>
    <span class="add-product-modal-component">
        <modal :show.sync="open" :wider="true">
            <div slot="header">
                <h3>Add Product To Quote</h3>
            </div>
            <div slot="body">
                <div class="product-search" v-show="! selected_product.id">
                    <type-ahead live-search-url="/admin/api/products/search"
                                v-on:typeahead-selected="setProduct"
                                :clear-on-hit="true"
                                :search-fields='["factory_number", "product_code"]'
                    ></type-ahead>
                </div>
                <div class="product-supply-select" v-show="selected_product.id">
                    <p class="lead"><strong>{{ selected_product.product_code }} {{ selected_product.name }}</strong></p>
                    <p v-show="selected_product.supplies.length === 0" class="lead">Product has no supplies on
                        record</p>
                    <table class="table table-responsive" v-show="selected_product.supplies.length">
                        <thead>
                        <tr>
                            <th>Select</th>
                            <th>Quoted Date</th>
                            <th>Factory Item #</th>
                            <th>Factory</th>
                            <th>Currency</th>
                            <th>Price</th>
                            <th>Package Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="product-supply-option" v-for="supply in selected_product.supplies">
                            <td>
                                <label :for="'supply_' + supply.id">
                                    <input type="radio" v-model="selected_supply_id" :id="'supply_' + supply.id"
                                           :value="supply.id">
                                </label>
                            </td>
                            <td>{{ supply.quoted_date }}</td>
                            <td>{{ supply.item_number }}</td>
                            <td>{{ supply.supplier.name }}</td>
                            <td>{{ supply.currency }}</td>
                            <td>{{ supply.price }}</td>
                            <td>{{ supply.package_price }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-light" v-show="selected_product.id"
                        @click="resetSelections">
                    Reset
                </button>
                <button class="btn dd-btn btn-grey"
                        @click="open = false">
                    Cancel
                </button>
                <button class="btn dd-btn btn-dark"
                        @click="addItemToQuote"
                >
                    Add Item
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
                selected_product: {
                    id: null,
                    supplies: []
                },
                selected_supply_id: null
            }
        },

        computed: {
            selected_supply() {
                return this.selected_product.supplies.find(supply => supply.id === this.selected_supply_id);
            }
        },

        events: {
            'add-item': function () {
                this.open = true;
            }
        },

        methods: {

            setProduct({id}) {
                this.$http.get('/admin/api/products/' + id)
                        .then(({data}) => this.selected_product = data)
                        .catch(err => console.log(err));
            },

            addItemToQuote() {
                this.$http.post('/admin/quotes/' + this.quoteId + '/items', {
                    product_id: this.selected_product.id,
                    supply_id: this.selected_supply_id
                }).then(() => this.onSuccess())
                        .catch(err => console.log(err));
            },

            onSuccess() {
                this.resetSelections();
                this.$dispatch('add-to-quote', {
                    product: this.selected_product,
                    supply: this.selected_supply
                });
                this.open = false;
            },

            resetSelections() {
                this.selected_product = {id: null, supplies: []};
                this.selected_supply_id = null;
            }
        }
    }
</script>