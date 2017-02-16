<style></style>

<template>
    <div class="type-ahead-component">
        <input type="text"
               class="type-ahead-input form-control"
               v-model="query"
               v-on:keydown.down="down"
               v-on:keydown.up="up"
               v-on:keydown.enter.prevent.stop="hit"
               v-on:keydown="letterPress($event)"
               v-on:keyup="requestSuggestions | debounce 200"
        >
        <ul class="type-ahead-suggestions">
            <li v-for="match in matches"
                class="list-group-item"
                :class="{'highlight': isCurrent(match)}"
                v-on:mouseenter="setCurrent(match)"
                v-on:mousedown="hit"
            >
                {{ match.name }}
            </li>
        </ul>
    </div>
</template>

<script type="text/babel">
    export default {

        props: {
            suggestions: {
                type: Array,
                required: false,
                default: function() { return []; }
            },
            'live-search-url': {
                type: String,
                required: false,
                default: null
            }
        },

        data() {
            return {
                query: '',
                current: null,
                current_index: null,
                selection: null,
                previous_live_search: null
            }
        },

        computed: {

            matches() {
                if (this.query === '') {
                    return;
                }
                return this.suggestions
                        .filter((suggestion) => {
                            return (suggestion.name.toLowerCase().indexOf(this.query.toLowerCase()) !== -1) && (!this.isSelected(suggestion));
                        });
            }
        },

        methods: {

            isCurrent(suggestion) {
                return this.current && (this.current.id === suggestion.id);
            },

            isSelected(match) {
                if (this.selection === null) {
                    return false;
                }
                return match.id === this.selection.id;
            },

            down() {
                this.incCurrentIndex();
                this.current = this.matches[this.current_index];
            },

            up() {
                this.decCurrentIndex();
                this.current = this.matches[this.current_index];
            },

            incCurrentIndex() {
                if (!this.hasMatches()) {
                    return;
                }

                if (this.current_index === null) {
                    return this.current_index = 0;
                }

                if (this.current_index >= (this.matches.length - 1)) {
                    return;
                }

                return this.current_index += 1;
            },

            decCurrentIndex() {
                if (!this.hasMatches() || (this.current_index <= 0) || this.current_index === null) {
                    return;
                }

                if (this.current_index >= this.matches.length - 1) {
                    return this.current_index = this.matches.length - 2;
                }

                return this.current_index -= 1;
            },

            letterPress(ev) {
                if (ev.keyCode === 40 || ev.keyCode === 38) {
                    return;
                }
                this.resetCurrent();
            },

            hit() {
                if (this.current === null) {
                    console.log('no selection');
                    return;
                }
                console.log(this.current.id + ': ' + this.current.name);
                this.$dispatch('typeahead-selected', this.current);
                this.setSelection();
            },

            setCurrent(match) {
                this.current_index = this.matches.indexOf(match);
                this.current = match;
            },

            setSelection() {
                this.selection = this.current;
                this.query = this.current.name;
            },

            resetCurrent() {
                this.current = null;
                this.current_index = null;
                if (this.selection && this.query !== this.selection.name) {
                    this.selection = null;
                }
            },

            hasMatches() {
                console.log(this.matches.length)
                return this.matches.length > 0;
            },

            requestSuggestions(ev) {
                if(this.query.length < 4 || !this.liveSearchUrl) {
                    return;
                }
                if(this.previous_live_search === this.query) {
                    return;
                }
                this.$http.post(this.liveSearchUrl, {searchterm: this.query})
                        .then(res => this.addFetchedSuggestions(res))
                        .catch(err => console.log(err));
                this.previous_live_search = this.query;
            },

            addFetchedSuggestions(res) {
                const results = res.data.slice(0,10);
                this.suggestions = results.map(item => ({id: item.id, name: item.name}));
            }
        }
    }
</script>