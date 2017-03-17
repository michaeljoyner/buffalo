<style></style>

<template>
    <span class="quote-search-form-component">
        <button class="btn dd-btn btn-light" @click="modalOpen = true">Search</button>
        <modal :show.sync="modalOpen" :wider="true" :fixed="true">
            <div slot="header">
                <h3>Search by Customer and/or Product</h3>
            </div>
            <div slot="body">
                <p class="text-center lead">Select a customer and/or a product to search for.</p>
                <div class="customer-search search-component">
                    <p class="field-label">Customer:</p>
                    <type-ahead :suggestions="customerList" v-on:typeahead-selected="setCustomer"></type-ahead>
                    <div class="selected-customer" v-show="selected_customer.name">
                        <h4 class="text-center">Selected Customer</h4>
                        <p class="lead">{{ selected_customer.name }}</p>
                    </div>
                </div>
                <div class="product-search search-component">
                    <p class="field-label">Product:</p>
                    <type-ahead live-search-url="/admin/api/products/search"
                                v-on:typeahead-selected="setProduct"
                                :clear-on-hit="true"
                                :search-fields='["factory_number", "product_code"]'
                    ></type-ahead>
                </div>
                <div class="selected-product" v-show="selected_product.name">
                    <h4 class="text-center">Selected Product</h4>
                    <p class="lead">{{ selected_product.name }}</p>
                </div>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-light"
                        @click="resetSelections">
                    Reset
                </button>
                <button class="btn dd-btn btn-grey"
                        @click="modalOpen = false">
                    Cancel
                </button>
                <a class="btn dd-btn btn-dark" :href="searchUrl" :disabled="disableForm">Search Quotes</a>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {

        data() {
            return {
                selected_customer: {name: null, id: null},
                selected_product: {name: null, id: null},
                modalOpen: false,
                customers: []
            };
        },

        computed: {

            customerList() {
                return this.customers.map(customer => ({name: customer.name, id: customer.id}));
            },

            disableForm() {
                return this.selected_customer.id === null && this.selected_product.id === null;
            },

            searchUrl() {
                if(this.disableForm) {
                    return '';
                }

                if(this.selected_product.id === null) {
                    return `/admin/quotes-search/customers/${this.selected_customer.id}`;
                }

                if(this.selected_customer.id === null) {
                    return `/admin/quotes-search/products/${this.selected_product.id}`;
                }

                return `/admin/quotes-search/customers/${this.selected_customer.id}/products/${this.selected_product.id}`;
            }
        },

        ready() {
            this.fetchCustomers();
        },

        methods: {

            fetchCustomers() {
                this.$http.get('/admin/api/customers')
                        .then(res => this.customers = res.data)
                        .catch(err => console.log(err));
            },

            setCustomer(customer) {
                this.selected_customer = customer;
            },

            setProduct(product) {
                this.selected_product = product;
            },

            resetSelections() {
                this.selected_product = {name: null, id: null};
                this.selected_customer = {name: null, id: null};
            }

        }
    }
</script>