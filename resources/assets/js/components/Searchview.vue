<style></style>

<template>
    <div class="search-view">
        <form action=""
              @submit.prevent.stop="doSearch"
              class="search-view-form">
            <input placeholder="Search by name or code"
                   type="text"
                   autofocus
                   v-model="searchterm"
                   @keypress="getSuggestions"
                   class="search-term"
                   autocomplete="off"
            >
            <div class="list-group suggestions">
                <a class="list-group-item"
                   :href="`/admin/products/${suggestion.id}`"
                   v-for="suggestion in first_ten_suggestions">
                    <span class="list-item-name">{{ suggestion.name }}</span>
                    <span class="badge">{{ suggestion.product_code }}</span>
                </a>
            </div>
        </form>
        <section class="search-results-list">
            <h3 v-if="!is_virgin && results.length === 0"
                class="results-header">No results for "{{ lastTermSearched }}"</h3>
            <h3 v-show="results.length"
                class="results-header">Search Results for "{{ lastTermSearched }}"</h3>
            <h6 v-show="results.length"
                class="results-subheader">Found {{ results.length }} products</h6>
            <div class="list-group">
                <a v-for="result in current_page_results"
                   class="list-group-item"
                   :href="`/admin/products/${result.id}`">
                    <img :src="result.thumb_img"
                         alt=""
                         width="50"
                         height="50">
                    <span class="lead list-item-name">{{ result.name }}</span>
                    <span class="badge">{{ result.product_category }}</span>
                    <span>{{ result.product_code }}</span>
                </a>
            </div>
            <div class="pagination"
                 v-show="results.length > pageSize">
                <div class="page-number"
                     v-for="index of Math.ceil(results.length/pageSize)"
                     :class="{'current': offset == index*pageSize}"
                     @click="showPage(index)"
                >{{ index + 1}}
                </div>
            </div>
        </section>
        <section v-show="is_virgin && !initialQuery"
                 class="product-stats">
            <slot></slot>
        </section>
    </div>
</template>

<script type="text/babel">

    import {debounce} from "lodash";

    export default {

        props: ['search-url', 'page-size', 'initial-query'],

        data() {
            return {
                searchterm: '',
                suggestions: [],
                results: [],
                lastTermSearched: '',
                offset: 0,
                is_virgin: true
            }
        },

        computed: {
            first_ten_suggestions() {
                return this.suggestions.slice(0, 10);
            },

            current_page_results() {
              return this.results.slice(this.offset, (this.offset + parseInt(this.pageSize)));
            }
        },

        mounted() {
            if(this.initialQuery) {
                this.searchterm = this.initialQuery;
                this.doSearch();
            }
        },

        methods: {

            getSuggestions: debounce(function(ev) {
                if(ev.keyCode === 13) {
                    return;
                }
                if (this.searchterm.length < 4) {
                    this.suggestions = [];
                    return;
                }
                axios.post(this.searchUrl, {searchterm: this.searchterm})
                     .then(({data}) => this.suggestions = data)
                     .catch(() => this.showSearchError());
            }, 200),

            doSearch() {
                if (this.searchterm.length < 1) {
                    return;
                }
                this.suggestions = [];
                this.lastTermSearched = this.searchterm;
                axios.post(this.searchUrl, {searchterm: this.searchterm})
                     .then(({data}) => this.onSearchSuccess(data))
                     .catch(() => this.showSearchError());
                this.searchterm = '';

            },

            onSearchSuccess(res) {
                this.suggestions = [];
                this.results = res;
                this.is_virgin = false;
                this.offset = 0;
            },

            showSearchError() {
                eventHub.$emit('user-alert', 'There was a problem performing the search. Maybe refresh the page and try again')
            },

            showPage(pageNumber) {
                this.offset = pageNumber * this.pageSize;
            }
        }
    }
</script>