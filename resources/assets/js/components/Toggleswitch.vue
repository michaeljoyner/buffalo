<style></style>

<template>
    <div class="toggle-switch">
        <span class="switch-status-label" :class="{'chosen': currentStatus}">{{ trueLabel }}</span>
        <label class="toggle-switch-label" :for="'toggle-switch-' + identifier">
            <input type="checkbox" :id="'toggle-switch-' + identifier" v-on:change="toggleState"
                   v-model="currentStatus">
            <div class="switch-bulb"></div>
        </label>
        <span class="switch-status-label" :class="{'chosen': ! currentStatus}">{{ falseLabel }}</span>
    </div>
</template>

<script type="text/babel">
    module.exports = {
        props: ['identifier', 'true-label', 'false-label', 'initial-state', 'toggle-url', 'toggle-attribute', 'current-status'],

        data() {
            return {
            }
        },

        ready() {
            if(!this.currentStatus) {
                this.currentStatus = this.initialState;
            }
        },

        computed: {
            currentLabel() {
                return this.currentStatus ? this.trueLabel : this.falseLabel;
            }
        },

        methods: {
            toggleState: function () {
                let initialState = !this.currentStatus;
                this.$http.post(this.toggleUrl, this.makePayloadFor(this.currentStatus))
                        .then((res) => this.currentStatus = res.data.new_state)
                        .catch((res) => this.currentStatus = initialState);
            },

            makePayloadFor(attributeState) {
                let body = {};
                body[this.toggleAttribute] = attributeState;
                return body;
            }
        }
    }
</script>