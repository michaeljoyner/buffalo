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
                <description-editor :item-id="itemData.itemId"
                                    :initial-content="itemData.description"
                ></description-editor>
                <delete-button :message="`Are you sure you want to remove ${itemData.name} from this quote?`"
                               :delete-url="'/admin/quoteitems/' + itemData.itemId"
                               v-on:item-deleted="deletedItem"
                >
                </delete-button>
                <button class="btn dd-btn btn-light" @click="editMode = true">
                    Edit
                </button>
                <supply-selector :product-id="initialProps.product_id"
                                 v-on:supply-selected="resetSupplyInfo"
                ></supply-selector>
            </div>
        </div>
        <modal :show.sync="editMode" :wider="true">
            <div slot="header">
                <h3>Edit Details for {{ itemData.buffalo_product_code }}</h3>
            </div>
            <div slot="body">
                <div class="quote-item-edit-form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="buffalo_product_code">Product Code: </label>
                                <input id="buffalo_product_code" type="text" v-model="itemData.buffalo_product_code">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name">Name: </label>
                                <input id="name" type="text" v-model="itemData.name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplier">Factory: </label>
                                <input id="supplier" type="text" v-model="itemData.supplier_name">
                            </div>
                            <div class="form-group">
                                <label for="factory_number">Factory Item #: </label>
                                <input id="factory_number" type="text" v-model="itemData.factory_number">
                            </div>

                            <div class="form-group">
                                <label for="remark">Remark: </label>
                                <textarea id="remark" v-model="itemData.remark"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Description: </label>
                                <div id="description">{{{ itemData.description }}}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="currency">Currency: </label>
                                <input id="currency" type="text" v-model="itemData.currency">
                            </div>
                            <div class="form-group">
                                <label for="exchange_rate">Exchange Rate: </label>
                                <input id="exchange_rate" type="number" step="0.001" min="0" v-model="itemData.exchange_rate">
                            </div>
                            <div class="form-group">
                                <label for="price">Factory Price: </label>
                                <input id="price" type="number" step="0.01" min="0" v-model="itemData.factory_price">
                            </div>
                            <div class="form-group">
                                <label for="package_price">Package Price: </label>
                                <input id="package_price" type="number" step="0.01" min="0" v-model="itemData.package_price">
                            </div>
                            <div class="form-group">
                                <label for="additional_cost">Additional Cost: </label>
                                <input id="additional_cost" type="number" step="0.01" min="0" v-model="itemData.additional_cost">
                            </div>
                            <div class="form-group">
                                <label for="additional_cost_memo">Additional Cost Note: </label>
                                <input id="additional_cost_memo" type="text" v-model="itemData.additional_cost_memo">
                            </div>
                            <div class="form-group">
                                <label for="profit">Profit rate: </label>
                                <input id="profit" type="number" step="0.001" min="0" v-model="itemData.profit">
                            </div>
                            <div class="form-group">
                                <label for="moq">MOQ: </label>
                                <input id="moq" type="number" step="1" min="0" v-model="itemData.moq">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity: </label>
                                <input id="quantity" type="number" step="1" min="0" v-model="itemData.quantity">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="package_type">Package type: </label>
                                <input id="package_type" type="text" v-model="itemData.package_type">
                            </div>
                            <div class="form-group">
                                <label for="package_unit">Package unit: </label>
                                <input id="package_unit" type="text" v-model="itemData.package_unit">
                            </div>
                            <div class="form-group">
                                <label for="package_inner">Package inner: </label>
                                <input id="package_inner" type="number" step="1" min="0" v-model="itemData.package_inner">
                            </div>
                            <div class="form-group">
                                <label for="package_outer">Package outer: </label>
                                <input id="package_outer" type="number" step="1" min="0" v-model="itemData.package_outer">
                            </div>
                            <div class="form-group">
                                <label for="package_carton">Package carton: </label>
                                <input id="package_carton" type="text" v-model="itemData.package_carton">
                            </div>
                            <div class="form-group">
                                <label for="net_weight">Net weight: </label>
                                <input id="net_weight" type="number" step="0.001" min="0" v-model="itemData.net_weight">
                            </div>
                            <div class="form-group">
                                <label for="gross_weight">Gross weight: </label>
                                <input id="gross_weight" type="number" step="0.001" min="0" v-model="itemData.gross_weight">
                            </div>
                        </div>
                    </div>
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
                    package_price: null,
                    additional_cost: null,
                    additional_cost_memo: null,
                    moq: null,
                    currency: '',
                    itemId: null,
                    quote_id: null,
                    product_id: null,
                    exchange_rate: null,
                    profit: null,
                    remark: null,
                    package_type: null,
                    package_unit: null,
                    package_inner: null,
                    package_outer: null,
                    package_carton: null,
                    net_weight: null,
                    gross_weight: null
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
            },

            resetSupplyInfo(supply) {
                this.itemData.supplier_name = supply.supplier.name;
                this.itemData.factory_number = supply.item_number;
                this.itemData.factory_price = supply.price;
                this.itemData.currency = supply.currency;

                this.updateItem();
            }
        }

    }
</script>