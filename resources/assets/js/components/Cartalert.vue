<style></style>

<template>
    <div class="cart-alert" :class="{'show': show}">
        <p class="alert-text">Products in inquiry: {{ quantity }}</p>
        <a class="alert-link" href="/inquiry">view</a>
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

        events: {
          'cart-item-added': function() {
              this.fetchSummary(true);
          }
        },

        ready() {
            this.fetchSummary(false);
        },

        methods: {

            fetchSummary(thenShow) {
                this.$http.get('/api/cart/summary')
                        .then((res) => this.setState(res, thenShow));
            },

            setState(res, show) {
                this.quantity = res.body.total_products;
                if(show) {
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