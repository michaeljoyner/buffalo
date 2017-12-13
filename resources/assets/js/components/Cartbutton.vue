<style></style>

<template>
    <form @submit.stop.prevent="addToCart" class="add-to-cart-form">
        <label>Quantity: </label>
        <input type="number" :min="moq" name="quantity" v-model="quantity" class="quantity-input">
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
    export default {
        props: ['product-id', 'moq'],

        data() {
            return {
                quantity: this.moq,
                adding: false
            }
        },

        methods: {
            addToCart() {
                if (this.quantity < this.moq) {
                    return this.quantity = this.moq;
                }

                this.adding = true;
                axios.post('/api/cart/items', {
                            product_id: this.productId,
                            quantity: this.quantity
                        })
                        .then(() => this.onSuccess())
                        .catch(() => this.onFail())
            },

            onSuccess() {
                this.adding = false;
                eventHub.$emit('cart-item-added', true);
                this.quantity = this.moq;
            },

            onFail() {
                this.adding = false;
                eventHub.$emit('error-alert', 'We were unable to add this product to the cart. Please refresh the page and try again. Thanks.');
            }
        }
    }
</script>