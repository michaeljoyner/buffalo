<style></style>

<template>
    <div class="cart-list">
        <cart-item v-for="item in items"
                   :key="item.id"
                   :product-id="item.id"
                   :product-name="item.name"
                   :thumb="item.thumb"
                   :product-code="item.product_code"
                   :product-qty="item.quantity"
                   :moq="item.minimum_order_quantity"
                   @delete-cart-item="removeItem"
        ></cart-item>
        <a class="btn page-section-cta checkout-button" href="/enquire" v-show="items.length">Proceed</a>
        <p class="sub-heading text-centered" v-show="!items.length">You don't have any products in your cart.</p>
    </div>
</template>

<script type="text/babel">
    export default {

        data: function() {
            return {
                items: []
            }
        },

        mounted() {
            this.fetchCartList();
        },

        methods: {

            fetchCartList() {
                axios.get('/api/cart/items')
                        .then(({data}) => this.items = data)
                        .catch(() => this.failedToFetch());
            },

            failedToFetch() {
              eventHub.$emit('error-alert', 'We were unable to fetch the contents of your inquiry. Please refresh the page and try again. Thanks');
            },

            removeItem(item_id) {
                let product = this.items.find(product => product.id === item_id);
                axios.delete(`/api/cart/items/${product.id}`)
                        .then(() => this.onItemDeletion(product))
                        .catch(() => console.log('unable to remove item'));
            },

            onItemDeletion(product) {
                const item = this.items.find(i => i.id === product.id);
                this.items.splice(this.items.indexOf(item), 1);
                eventHub.$emit('item-removed');
            }
        }
    }
</script>