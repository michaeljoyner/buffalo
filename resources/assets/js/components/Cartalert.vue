<style></style>

<template>
    <div class="cart-alert"
         :class="{'show': show}">
        <p class="alert-text">Products in inquiry: {{ quantity }}</p>
        <a class="alert-link"
           href="/inquiry">view</a>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        data() {
            return {
                show: false,
                quantity: null
            }
        },

        mounted() {
            eventHub.$on('cart-item-added', this.fetchSummary);
            this.fetchSummary(false);
        },

        methods: {

            fetchSummary(thenShow = true) {
                console.log('here');
                axios.get('/api/cart/summary')
                     .then(({data}) => this.setState(data, thenShow))
                     .catch(() => eventHub.$emit('error-alert', 'Failed to fetch cart cart summary'));
            },

            setState(data, show) {
                this.quantity = data.total_products;
                if (show) {
                    this.showAlert();
                }
            },

            showAlert() {
                this.show = true;
                window.setTimeout(() => this.show = false, 3000);
            }
        }
    }
</script>