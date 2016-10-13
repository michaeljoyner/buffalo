<style></style>

<template>
    <div class="search-view">
        <form action="" v-on:submit.prevent.stop="doSearch" class="search-view-form">
            <input placeholder="Search by name or code"
                   type="text"
                   autofocus
                   v-model="searchterm"
                   v-on:keyUp="getSuggestions | debounce 200"
                   class="search-term"
            >
            <div class="list-group suggestions">
                <a class="list-group-item" href="/admin/products/{{ suggestion.id }}" v-for="suggestion in suggestions | limitBy 10">
                    <span class="list-item-name">{{ suggestion.name }}</span>
                    <span class="badge">{{ suggestion.product_code }}</span>
                </a>
            </div>
        </form>
        <section class="search-results-list">
            <h3 v-show="results.length" class="results-header">Search Results for "{{ lastTermSearched }}"</h3>
            <h6 v-show="results.length" class="results-subheader">Found {{ results.length }} products</h6>
            <div class="list-group">
                <a v-for="result in results | limitBy pageSize offset" class="list-group-item" href="/admin/products/{{ result.id }}">
                    <span class="lead list-item-name">{{ result.name }}</span>
                    <span class="badge">{{ result.category.name }}</span>
                    <span>{{ result.product_code }}</span>
                </a>
            </div>
            <div class="pagination" v-show="results.length > pageSize">
                <div class="page-number"
                     v-for="index of Math.ceil(results.length/pageSize)"
                     :class="{'current': offset == index*pageSize}"
                     v-on:click="showPage(index)"
                >{{ index + 1}}</div>
            </div>
        </section>
        <section v-show="!results.length" class="product-stats">
            <slot></slot>
        </section>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: ['search-url', 'page-size'],

        data() {
            return {
                searchterm: '',
                suggestions: [],
                results: [],
                lastTermSearched: '',
                offset: 5
            }
        },

        methods: {

            getSuggestions() {
                if(this.searchterm.length < 4) {
                    this.suggestions = [];
                    return;
                }
                this.$http.post(this.searchUrl, {searchterm: this.searchterm})
                        .then((res) => this.suggestions = res.data)
                        .catch(() => console.log('error'));
            },

            doSearch() {
                if(this.searchterm.length < 1) {
                    return;
                }
                this.lastTermSearched = this.searchterm;
                this.$http.post(this.searchUrl, {searchterm: this.searchterm})
                        .then((res) => this.onSearchSuccess(res.data))
                        .catch(() => console.log('search error'));
                this.searchterm = '';
                this.suggestions = [];
            },

            onSearchSuccess(res) {
                this.results = res;
                this.offset = 0;
            },

            showPage(pageNumber) {
                this.offset = pageNumber * this.pageSize;
            }
    }
    }
</script>