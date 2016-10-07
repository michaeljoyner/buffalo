<style></style>

<template>
    <form action="" v-on:submit.stop.prevent="addToCart" class="add-to-cart-form">
        <label>Quantity: </label>
        <input type="number" min="1" name="quantity" v-model="quantity" class="quantity-input">
        <button class="btn add-cart-btn" type="submit" :disabled="adding">
            <span v-show="!adding">Add to cart</span>
            <div class="spinner" v-show="adding">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </button>
    </form>
</template>

<script type="text/babel">
    module.exports = {
        props: ['product-id'],

        data() {
            return {
                quantity: 1,
                adding: false
            }
        },

        methods: {
            addToCart() {
                if (this.quantity < 1) {
                    return this.quantity = 1;
                }
                this.adding = true;
                this.$http.post('/api/cart/items', {
                            product_id: this.productId,
                            quantity: this.quantity
                        })
                        .then(() => this.onSuccess())
                        .catch(() => this.onFail())
            },

            onSuccess() {
                this.adding = false;
                this.$dispatch('item-added');
                this.quantity = 1;
            },

            onFail() {
                this.adding = false;
                this.$dispatch('user-alert', {
                    type: 'error',
                    title: 'Oops, an error occurred.',
                    text: 'We were unable to add this product to the cart. Please refresh the page and try again. Thanks.',
                });
            }
        }
    }
</script>