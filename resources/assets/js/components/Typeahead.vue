<style></style>

<template>
    <div class="type-ahead-component">
        <input type="text"
               class="type-ahead-input form-control"
               v-model="query"
               @keydown.down="down"
               @keydown.up="up"
               @keydown.enter.prevent.stop="hit"
               @keydown="letterPress($event)"
               @keyup="requestSuggestions"
        >
        <ul class="type-ahead-suggestions">
            <li v-for="match in matches" :key="match.id"
                class="list-group-item"
                :class="{'highlight': isCurrent(match)}"
                @mouseenter="setCurrent(match)"
                @mousedown="hit"
            >
                {{ match.name }}
                <span class="type-ahead-sub-field" v-if="subField">{{ match[this.subField] }}</span>
            </li>
        </ul>
    </div>
</template>

<script type="text/babel">

    import {debounce} from "lodash";

    export default {

        props: {
            suggestions: {
                type: Array,
                required: false,
                default: function () {
                    return [];
                }
            },
            'sub-field': {
                type: String,
                required: false,
                default: null
            },
            'live-search-url': {
                type: String,
                required: false,
                default: null
            },
            'clear-on-hit': {
                type: Boolean,
                required: false,
                default: false
            },
            'search-fields': {
                type: Array,
                required: false,
                default: function() {
                    return [];
                }
            }
        },

        data() {
            return {
                query: '',
                current: null,
                current_index: null,
                selection: null,
                previous_live_search: null,
                real_suggestions: this.suggestions
            }
        },

        computed: {

            matches() {
                if (this.query === '') {
                    return;
                }
                return this.real_suggestions
                        .filter((suggestion) => {
                            return (this.suggestionMatchesQuery(suggestion)) && (!this.isSelected(suggestion));
                        });
            }
        },

        watch: {
          suggestions(fetched_suggestions) {
              if(this.real_suggestions.length === 0) {
                  this.real_suggestions = fetched_suggestions;
              }
          }
        },

        methods: {

            getSearchFields() {
                return ['name'].concat(this.searchFields);
            },

            suggestionMatchesQuery(suggestion) {
                return this.getSearchFields().some((field) => {
                    return suggestion.hasOwnProperty(field) &&
                            suggestion[field] &&
                            this.wordMatchesQuery(suggestion[field]);
                });
            },

            wordMatchesQuery(word) {
              return word.toLowerCase().indexOf(this.query.toLowerCase()) !== -1;
            },

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
                    return;
                }
                this.$emit('typeahead-selected', this.current);
                this.setSelection();
                if (this.clearOnHit) {
                    this.query = '';
                }
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
                return this.matches.length > 0;
            },

            requestSuggestions: debounce(function() {
                if (this.query.length < 4 || !this.liveSearchUrl) {
                    return;
                }
                if (this.previous_live_search === this.query) {
                    return;
                }
                axios.post(this.liveSearchUrl, {searchterm: this.query})
                     .then(({data}) => this.addFetchedSuggestions(data))
                     .catch(err => console.log(err));
                this.previous_live_search = this.query;
            }, 200),

            addFetchedSuggestions(res) {
                const results = res.slice(0, 10);
                this.real_suggestions = results;//.map(item => ({id: item.id, name: item.name}));
            }
        }
    }
</script>