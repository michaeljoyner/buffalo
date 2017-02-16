<style></style>

<template>
    <div class="customer-search-component">
        <type-ahead :suggestions="customerList" v-on:typeahead-selected="setSelectedCustomer"></type-ahead>
        <div class="selected-customer-details">
            <p>Name: {{ selected_customer.name }}</p>
            <p>Contact Person: {{ selected_customer.contact_person }}</p>
            <p>Email: {{ selected_customer.email }}</p>
            <form v-show="selected_customer.id"
                  :action="'/admin/customers/' + selected_customer.id + '/quotes'"
                  method="POST">
                <input type="hidden" value="{{ csrf_token }}" name="_token">
                <input type="hidden" value="{{ order }}" name="order_id">
                <button class="btn dd-btn btn-light" type="submit">Quote {{ selected_customer.name }}</button>
            </form>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['order', 'csrf_token'],

        data() {
            return {
                selected_customer: {id: null, name: '', contact_person: ''},
                customers: []
            };
        },

        ready() {
            this.fetchCustomers();
        },

        computed: {
            customerList() {
                return this.customers.map(customer => ({name: customer.name, id: customer.id}));
            }
        },

        methods: {
            fetchCustomers() {
                this.$http.get('/admin/api/customers')
                        .then(res => this.customers = res.data)
                        .catch(err => console.log(err));
            },

            setSelectedCustomer(customer) {
                this.selected_customer = this.customers.find(c => c.id === customer.id);
            }
        }

    }
</script>