<style></style>

<template>
    <div class="quote-item-component">
        <p class="lead">
            <span class="quote-item-code">{{ itemData.buffalo_product_code }}</span> |
            <span class="quote-item-name">{{ itemData.name }}</span>
        </p>
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Factory Item #</th>
                <th>Factory/Supplier</th>
                <th>Factory Price</th>
                <th>Currency</th>
                <th>Exchange Rate</th>
                <th>Quantity</th>
            </tr>
            <tbody>
            <tr>
                <td>{{ itemData.factory_number }}</td>
                <td>{{ itemData.supplier_name }}</td>
                <td>{{ itemData.factory_price }}</td>
                <td>{{ itemData.currency }}</td>
                <td>{{ itemData.exchange_rate }}</td>
                <td>{{ itemData.quantity }}</td>
            </tr>
            </tbody>
            </thead>
        </table>
        <div class="component-footer clearfix">
            <div class="component-actions pull-right">
                <delete-button :message="`Are you sure you want to remove ${itemData.name} from this quote?`"
                               :delete-url="'/admin/quoteitems/' + itemData.itemId"
                               v-on:item-deleted="deletedItem"
                >
                </delete-button>
                <button class="btn dd-btn btn-light" @click="editMode = true">
                    Edit
                </button>
            </div>
        </div>
        <modal :show.sync="editMode" :wider="true">
            <div slot="header">
                <h3>Edit Details for {{ itemData.buffalo_product_code }}</h3>
            </div>
            <div slot="body">
                <div class="form-group">
                    <label for="supplier">Factory: </label>
                    <input id="supplier" type="text" v-model="itemData.supplier_name">
                </div>
                <div class="form-group">
                    <label for="factory_number">Factory Item #: </label>
                    <input id="factory_number" type="text" v-model="itemData.factory_number">
                </div>
                <div class="form-group">
                    <label for="price">Factory Price: </label>
                    <input id="price" type="text" v-model="itemData.factory_price">
                </div>
                <div class="form-group">
                    <label for="currency">Currency: </label>
                    <input id="currency" type="text" v-model="itemData.currency">
                </div>
                <div class="form-group">
                    <label for="exchange_rate">Exchange Rate: </label>
                    <input id="exchange_rate" type="text" v-model="itemData.exchange_rate">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity: </label>
                    <input id="quantity" type="text" v-model="itemData.quantity">
                </div>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-grey"
                        @click="editMode = false">
                    Cancel
                </button>
                <button class="btn dd-btn btn-dark"
                        @click="updateItem"
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
    </div>
</template>

<script type="text/babel">
    export default {

        props: {
            'initial-props': {
                type: Object,
                required: true,
            }
        },

        data() {
            return {
                itemData: {
                    name: '',
                    description: '',
                    quantity: null,
                    buffalo_product_code: '',
                    supplier_name: '',
                    factory_number: null,
                    factory_price: null,
                    currency: '',
                    itemId: null,
                    quote_id: null,
                    product_id: null,
                    exchange_rate: null,
                },
                editMode: false,
                saving: false
            };
        },

        ready() {
            this.inflateProps();
        },

        methods: {

            inflateProps() {
                Object.keys(this.initialProps).forEach(key => {
                    if (this.itemData.hasOwnProperty(key) && key !== 'id') {
                        this.itemData[key] = this.initialProps[key];
                    }
                });
                this.itemData.itemId = this.initialProps.id;
            },

            updateItem() {
                this.saving = true;
                this.$http.patch('/admin/quoteitems/' + this.itemData.itemId, this.validFields())
                        .then(({data}) => this.onUpdate(data))
                        .catch(err => console.log('error: ', err));
            },

            onUpdate(data) {
                this.saving = false;
                this.editMode = false;
            },

            validFields() {
                return Object.keys(this.itemData).filter(key => {
                    return this.itemData[key] !== null;
                }).reduce((acc, key) => {
                    acc[key] = this.itemData[key];
                    return acc;
                }, {});
            },

            deletedItem() {
                this.$dispatch('remove-quoteitem', {id: this.itemData.itemId});
            }
        }

    }
</script>