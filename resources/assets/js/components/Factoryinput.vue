<style></style>

<template>
    <div class="form-group factory-search-input">
        <label for="supplier-id">Supplier: </label><span v-show="errorMessage">{{ errorMessage }}</span>
        <type-ahead :suggestions="factoryList" @typeahead-selected="setSelection"></type-ahead>
        <input type="hidden" name="supplier_id" v-model="selected_factory.id">
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['factory-list', 'error-message'],

        data() {
            return {
                selected_factory: {name: '', id: null}
            }
        },

        methods: {
            setSelection(factory) {
                this.selected_factory = factory;
            }
        }
    }
</script>