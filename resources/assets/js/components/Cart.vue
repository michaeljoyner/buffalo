<style></style>

<template>
    <div class="cart-list">
        <cart-item v-for="item in items"
                   :product-id="item.id"
                   :product-name="item.name"
                   :thumb="item.thumb"
                   :product-code="item.product_code"
                   :product-qty="item.quantity"
                   :moq="item.minimum_order_quantity"
        ></cart-item>
        <a class="btn page-section-cta checkout-button" href="/enquire" v-show="items.length">Proceed</a>
        <p class="sub-heading text-centered" v-else>You don't have any products in your cart.</p>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        data: function() {
            return {
                items: []
            }
        },

        ready: function() {
            this.fetchCartList();
        },

        events: {
            'delete-cart-item': function(item) {
                this.removeItem(item);
            }
        },

        methods: {

            fetchCartList() {
                this.$http.get('/api/cart/items')
                        .then((res) => this.setItems(res))
                        .catch(() => this.failedToFetch());
            },

            setItems(res) {
              this.$set('items', res.body);
            },

            failedToFetch() {
              this.$dispatch('user-alert', {
                  type: 'error',
                  title: 'Oh dear, an error occurred.',
                  text: 'We were unable to fetch the contents of your inquiry. Please refresh the page and try again. Thanks'
              });
            },

            removeItem(item) {
                let product = this.items.filter(product => product.id === item.id).pop();
                this.$http.delete('/api/cart/items/' + item.id, {body: item})
                        .then(() => this.onItemDeletion(product))
                        .catch(() => console.log('unable to remove item'));
            },

            onItemDeletion(item) {
                this.items.$remove(item);
                this.$dispatch('item-removed');
            }
        }
    }
</script>