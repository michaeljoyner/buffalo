<style></style>

<template>
    <div class="category-mover-outer">
        <button class="dd-btn btn-dark btn" @click="open = true">Change category</button>
        <modal :show="open" :wider="true">
            <div slot="header">
                <h3>Change Category</h3>
                <p><small class="indicator">Current Category: {{ currentCategory }}</small></p>
                <small class="indicator">Move {{ productName }} to {{ destination }}</small>
            </div>
            <div slot="body">
                <div class="category-chooser">
                    <div class="category_choice-list">
                        <h6 class="list-header">Categories</h6>
                        <div class="choice"
                             v-for="(category, index) in categories" :key="category.id"
                             @click="setCategory(index)"
                             :class="{'selected': selected_category_index === index}"
                        >
                            <span>{{ category.name }}</span>
                        </div>
                    </div>
                    <div class="subcategory-choice-list">
                        <h6 class="list-header">Subcategories</h6>
                        <div class="choice"
                             v-for="subcategory in subcategories" :key="subcategory.id"
                             @click="setSubcategory(subcategory.id)"
                             :class="{'selected': selected_subcategory_id === subcategory.id}"
                        >
                            <span>{{ subcategory.name }}</span>
                        </div>
                        <p class="placeholder" v-if="!subcategories.length">No Subcategories</p>
                    </div>
                    <div class="poductgroup-choice-list">
                        <h6 class="list-header">Product Groups</h6>
                        <div class="choice"
                             v-for="productGroup in productGroups" :key="productGroup.id"
                             @click="setProductGroup(productGroup.id)"
                             :class="{'selected': selected_productgroup_id === productGroup.id}"
                        >
                            <span>{{ productGroup.name }}</span>
                        </div>
                        <p class="placeholder" v-if="!productGroups.length">No Product Groups</p>
                    </div>
                </div>
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-grey"
                        @click="open = false">
                    Cancel
                </button>
                <form :action="form_action" method="post">
                    <input type="hidden" :value="csrf_token" name="_token">
                    <button class="btn dd-btn btn-dark"
                            type="submit"
                            :disabled="selected_category_index === null"
                    >
                        Move
                    </button>
                </form>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['csrf_token', 'product-id', 'product-name', 'current-category'],

        data() {
            return {
                open: false,
                url: '/blah',
                categories: [],
                selected_category_index: null,
                selected_subcategory_id: null,
                selected_productgroup_id: null
            }
        },

        computed: {
            form_action() {
                if (this.selected_category_index === null) {
                    return '';
                }
                return this.createFormUrl();
            },

            subcategories() {
                if (this.selected_category_index === null) {
                    return [];
                }

                return this.categories[this.selected_category_index].subcategories;
            },

            productGroups() {
                if (this.selected_subcategory_id === null || this.selected_category_index === null) {
                    return [];
                }

                return this.getSubcategory().product_groups;
            },

            destination() {
                if(this.selected_category_index === null) {
                    return;
                }

                if (this.selected_productgroup_id) {
                    return this.getCategory().name + ' >> ' + this.getSubcategory().name + ' >> ' + this.getProductGroup().name;
                }

                if (this.selected_subcategory_id) {
                    return this.getCategory().name + ' >> ' + this.getSubcategory().name;
                }
                return this.getCategory().name;
            }
        },

        mounted() {
            this.fetchCategories();
        },

        methods: {
            fetchCategories() {
                axios.get('/admin/productcategories/categories')
                        .then(({data}) => this.categories = data)
                        .catch((err) => console.log(err));
            },

            setCategory(index) {
                if (this.selected_subcategory_id) {
                    this.selected_subcategory_id = null;
                }
                if(this.selected_productgroup_id) {
                    this.selected_productgroup_id = null;
                }
                this.selected_category_index = index;
            },

            setSubcategory(id) {
                if(this.selected_productgroup_id) {
                    this.selected_productgroup_id = null;
                }
                this.selected_subcategory_id = id;
            },

            setProductGroup(id) {
                this.selected_productgroup_id = id;
            },

            createFormUrl() {
                if (this.selected_productgroup_id) {
                    return `/admin/products/${this.productId}/productgroup/${this.selected_productgroup_id}`;
                }

                if (this.selected_subcategory_id) {
                    return `/admin/products/${this.productId}/subcategory/${this.selected_subcategory_id}`;
                }

                return `/admin/products/${this.productId}/category/${this.categories[this.selected_category_index].id}`;
            },

            getCategory() {
                return this.categories[this.selected_category_index];
            },

            getSubcategory() {
                return this.categories[this.selected_category_index].subcategories
                        .find((subcat) => this.selected_subcategory_id === subcat.id);
            },

            getProductGroup() {
                return this.getSubcategory().product_groups.find((group) => this.selected_productgroup_id === group.id);
            }
        }
    }
</script>