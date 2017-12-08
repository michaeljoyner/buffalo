<style></style>

<template>
    <div class="toggle-switch">
        <span class="switch-status-label" :class="{'chosen': currentStatus}">{{ trueLabel }}</span>
        <label class="toggle-switch-label" :for="'toggle-switch-' + identifier">
            <input type="checkbox" :id="`toggle-switch-${identifier}`" @change="toggleState"
                   v-model="currentStatus">
            <div class="switch-bulb"></div>
        </label>
        <span class="switch-status-label" :class="{'chosen': ! currentStatus}">{{ falseLabel }}</span>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['identifier', 'true-label', 'false-label', 'initial-state', 'toggle-url', 'toggle-attribute'],

        data() {
            return {
                currentStatus: this.initialState
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
                axios.post(this.toggleUrl, this.makePayloadFor(this.currentStatus))
                        .then(({data}) => this.currentStatus = data.new_state)
                        .catch(() => this.currentStatus = initialState);
            },

            makePayloadFor(attributeState) {
                let body = {};
                body[this.toggleAttribute] = attributeState;
                return body;
            }
        }
    }
</script>