<style></style>

<template>
    <span class="finalise-quote-button-component">
        <button @click="open = true" class="btn dd-btn">Finalise</button>
        <modal :show.sync="open" :wider="true">
            <div slot="header">
                <h3>Are you ready to finalise this quote?</h3>
            </div>
            <div slot="body">
                <p class="lead">You are about to finalise this quote. Once you do, it may no longer be edited. Please
                    check to see if everything is correct.</p>
                <p>
                    <span class="dot-indicator" :class="{'green': hasAllExpectedFields, 'red': !hasAllExpectedFields}"></span>
                    <strong>Quote Has All Necessary Info: </strong>
                    {{ has_all_fields }}
                </p>
                <p v-show="!hasAllExpectedFields"><strong>Missing Fields: </strong>{{ missing_fields }}</p>
                <p><strong>Number of items: </strong>{{ items.length }}</p>
                <p v-show="very_incomplete_total">
                    <span class="dot-indicator red"></span>
                    <strong>{{ very_incomplete_total }}</strong> items are <strong>very incomplete</strong>
                </p>
                <p v-show="incomplete_total">
                    <span class="dot-indicator red"></span>
                    <strong>{{ incomplete_total }}</strong> items are <strong>quite incomplete</strong>
                </p>
                <p v-show="almost_complete_total">
                    <span class="dot-indicator orange"></span>
                    <strong>{{ almost_complete_total }}</strong> items are <strong>almost complete</strong>
                </p>
                <p v-show="complete_total">
                    <span class="dot-indicator green"></span>
                    <strong>{{ complete_total }}</strong> items are <strong>complete</strong>
                </p>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-grey"
                        @click="open = false">
                    Cancel
                </button>
                <form :action="`/admin/quotes/${quoteId}/finalise`" method="POST" class="dd-form dd-button-form">
                    <input type="hidden" :value="csrfToken" name="_token">
                    <button class="btn dd-btn btn-dark"
                            @click="finaliseQuote"
                    >
                        Finalise Quote
                    </button>
                </form>

            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {
        props: ['quote-id', 'csrf-token'],

        data() {
            return {
                hasAllExpectedFields: null,
                missingFields: [],
                items: [],
                open: false
            };
        },

        computed: {
            missing_fields() {
                return this.missingFields.join(', ');
            },

            has_all_fields() {
                return this.hasAllExpectedFields ? 'Yes' : 'No';
            },

            very_incomplete_total() {
                return this.items.filter(item => item['completeness_level'] === 1).length;
            },

            incomplete_total() {
                return this.items.filter(item => item['completeness_level'] === 2).length;
            },

            almost_complete_total() {
                return this.items.filter(item => item['completeness_level'] === 3).length;
            },

            complete_total() {
                return this.items.filter(item => item['completeness_level'] === 4).length;
            }
        },

        ready() {
            this.getReport();
        },

        methods: {
            getReport() {
                this.$http.get(`/admin/quotes/${this.quoteId}/completeness`)
                        .then(({data}) => this.setData(data))
                        .catch(err => console.log(err));
            },

            setData(data) {
                this.hasAllExpectedFields = data.hasAllExpectedFields;
                this.missingFields = data.missingFields;
                this.items = data.items;
            },

            finaliseQuote() {

            }
        }
    }
</script>