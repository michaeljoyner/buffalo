<style></style>

<template>
    <span class="supply-selector-component">
        <button class="btn dd-btn btn-dark" @click="fetchSupplies">
            Set Supply
        </button>
        <modal :show="openModal" :wider="true">
            <div slot="header">
                <h3>Select the supply information</h3>
            </div>
            <div slot="body">
                <p v-show="supplies.length === 0" class="lead">Product has no supplies on
                    record</p>
                <table class="table table-responsive" v-show="supplies.length">
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
                    <tr class="product-supply-option" v-for="supply in supplies">
                        <td>
                            <label :for="'supply_' + supply.id">
                                <input type="radio"
                                       v-model="selected_supply_id"
                                       :id="'supply_' + supply.id"
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
            <div slot="footer">
                <button class="btn dd-btn btn-grey"
                        @click="openModal = false">
                    Cancel
                </button>
                <button class="btn dd-btn btn-dark"
                        @click="publishSelection"
                        :disabled="!selected_supply_id"
                >
                    <span>Use Supply</span>
                </button>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {

        props: ['product-id', 'product-name'],

        data() {
            return {
                openModal: false,
                supplies: [],
                selected_supply_id: null
            };
        },

        methods: {
            fetchSupplies() {
                axios.get(`/admin/api/products/${this.productId}/supplies`)
                        .then(({data}) => this.onFetched(data))
                        .catch(err => console.log(err));
            },

            onFetched(supplies) {
                this.supplies = supplies;
                this.openModal = true;
            },

            publishSelection() {
                const sup = this.supplies.find(supply => supply.id === this.selected_supply_id);
                this.$emit('supply-selected', sup);
                this.openModal = false;
            }
        }
    }
</script>