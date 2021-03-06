<style></style>

<template>
    <div class="cart-item">
        <div class="cart-item-thumb-box">
            <img :src="thumb" :alt="productName" width="50px" height="50px">
        </div>
        <span class="cart-item-name">{{ productName }}</span>
        <div class="cart-item-qty-box">
            <div v-show="!editing" class="edit-show">
                <span class="cart-item-quantity number">{{ quantity }}</span>
                <button class="cart-edit-btn small-action-btn btn" @click="editing = ! editing">
                    Edit
                </button>
            </div>
            <div v-show="editing" class="edit-edit">
                <form @submit.stop.prevent="editQuantity">
                    <input class="number qty-input" type="number" :min="moq" v-model="quantity">
                    <button class="cart-save-btn small-action-btn btn">
                        <span v-show="!saving">Save</span>
                        <div class="spinner" v-show="saving">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </button>
                </form>
            </div>
        </div>
        <span class="cart-item-code">{{ productCode }}</span>
        <div class="cart-item-trash">
            <button @click.prevent="deleteItem">
                <svg fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z"/>
                    <path d="M0 0h24v24H0z" fill="none"/>
                </svg>
            </button>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['product-id', 'product-name', 'thumb', 'product-qty', 'product-code', 'moq'],

        data() {
            return {
                quantity: this.productQty,
                editing: false,
                saving: false
            }
        },

        methods: {
            editQuantity() {
                if(this.quantity < this.moq) {
                    return this.quantity = this.moq;
                }

                this.saving = true;
                axios.post(`/api/cart/items/${this.productId}`, {id: this.productId, quantity: this.quantity})
                        .then(({data}) => this.onSuccessfulUpdate(data))
                        .catch(() => this.onUpdateFailure());
            },

            onSuccessfulUpdate(responseData) {
                this.subtotal = responseData.subtotal;
                this.saving = false;
                this.editing = false;
                this.$emit('item-updated');
            },

            onUpdateFailure() {
                this.saving = false;
                eventHub.$emit('error-alert', 'There was an error updating the quantity of your cart item. Please try again, or refresh the page. If you have further problems please contact us and we will help you directly. Thanks');
            },

            deleteItem() {
                this.$emit('delete-cart-item', this.productId);
            }
        }
    }
</script>