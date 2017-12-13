<style></style>

<template>
    <span class="clone-quote-form-component">
        <button class="btn dd-btn btn-dark" @click="modalOpen = true">Clone</button>
        <modal :show="modalOpen" :fixed="true">
            <div slot="header">
                <h3>Select a customer to copy quote to</h3>
            </div>
            <div slot="body">
                <div class="customer-search-component">
                    <type-ahead :suggestions="customerList" @typeahead-selected="setSelectedCustomer"></type-ahead>
                    <div class="selected-customer-details">
                        <p>Name: {{ selected_customer.name }}</p>
                        <p>Contact Person: {{ selected_customer.contact_person }}</p>
                        <p>Email: {{ selected_customer.email }}</p>
                    </div>
                </div>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-clear-danger"
                        v-show="selected_customer.id"
                        @click="resetSelection">
                    Reset
                </button>
                <button class="btn dd-btn btn-grey"
                        @click="modalOpen = false">
                    Cancel
                </button>
                <form :action="`/admin/customers/${selected_customer.id}/clone-quote/${quoteId}`"
                      class="dd-button-form"
                      method="POST">
                    <input type="hidden" :value="csrf_token" name="_token">
                    <button class="btn dd-btn"
                            :disabled="!selected_customer.id"
                            type="submit">Copy</button>
                </form>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {
        props: ['csrf_token', 'quote-id'],

        data() {
            return {
                modalOpen: false,
                selected_customer: {id: null, name: '', contact_person: ''},
                customers: []
            };
        },

        mounted() {
            this.fetchCustomers();
        },

        computed: {
            customerList() {
                return this.customers.map(customer => ({name: customer.name, id: customer.id}));
            }
        },

        methods: {
            fetchCustomers() {
                axios.get('/admin/api/customers')
                        .then(({data}) => this.customers = data)
                        .catch(err => console.log(err));
            },

            setSelectedCustomer(customer) {
                this.selected_customer = this.customers.find(c => c.id === customer.id);
            },

            resetSelection() {
                this.selected_customer = {id: null, name: '', contact_person: ''};
            }
        }

    }
</script>