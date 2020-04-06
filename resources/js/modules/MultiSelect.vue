<template>
    <div :class="[classes.wrapper]" class="shadow-sm" ref="vuesingleselect">
        <select multiple class="hidden" :name="name">
            <option v-for="(option, idx) in selectedOptions" :key="idx" :value="getOptionValue(option)">
                {{getOptionValue(option)}}
            </option>
        </select>

        <div class="relative text-left" :class="[classes.searchWrapper]">
            <div class="rounded bordered border-grey hover:border-blue bg-white" :class="[isRequired]">
                <ul class="flex list-reset flex-wrap m-0 text-black">
                    <li v-for="(option, idx) in selectedOptions" :key="idx"
                        @click="seedSearchText"
                        class="flex justify-between content-center"
                    >
                        <slot name="pill" v-bind="{option,idx}">
                            <span :class="[classes.pill]">
                                <span class="text-sm" v-text="getOptionDescription(option)"></span>
                                <span class="pl-2 text-grey-darker mt-px icons" @click.stop="removeOption(idx)">
                                    <svg class="text-sm w-3 h-3 fill-current" aria-hidden="true" viewBox="0 0 512 512">
                                        <path
                                            d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path>
                                    </svg>
                                </span>
                            </span>
                        </slot>
                    </li>
                    <li class="flex-1 pl-1" style="min-width: 50px;">
                        <input type="text" ref="search"
                               class="pl-3"
                               :class="[classes.searchInput]"
                               @click="seedSearchText"
                               @keyup.enter="setPossibleOption"
                               @keyup.down="movePointerDown"
                               @keydown.tab.stop="closeOut"
                               @keydown.esc.stop="searchText = null"
                               @keyup.up="movePointerUp"
                               @keyup.delete="popSelectedOption"
                               autocomplete="off"
                               :placeholder="placeholder"
                               :required="required"
                               v-model="searchText"
                               :readonly="readonly"
                        >
                    </li>
                </ul>
            </div>
            <ul tabindex="-1" ref="options" v-show="matchingOptions"
                :style="{'max-height': maxHeight}" style="z-index: 100;"
                :class=[classes.dropdown]
                class="absolute w-full overflow-auto appearance-none p-2 text-left list-reset bg-white mt-3"
            >
                <li tabindex="-1"
                    v-for="(option, idx) in matchingOptions" :key="idx"
                    :class="idx === pointer ? classes.active : ''"
                    class="cursor-pointer outline-none hover:bg-gray-100"
                    @blur="handleClickOutside($event)"
                    @mouseover="setPointerIdx(idx)"
                    @keyup.enter="setOption(option)"
                    @keyup.up="movePointerUp()"
                    @keyup.down="movePointerDown()"
                    @click.prevent="setOption(option)"
                >
                    <slot name="option" v-bind="{option,idx}">
                        {{ getOptionDescription(option) }}
                    </slot>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    import pointerScroll from "./pointerScroll";

    export default {
        mixins: [pointerScroll],
        mounted() {
            document.addEventListener("click", this.handleClickOutside);
            document.addEventListener("keyup", this.handleClickOutside);
            this.searchText = this.initial;
        },
        destroyed() {
            document.removeEventListener("keyup", this.handleClickOutside);
            document.removeEventListener("click", this.handleClickOutside);
        },
        watch: {
            value(curr, prev) {
                if (curr === prev) {
                    return;
                }

                this.selectedOptions = curr;
            },
            searchText(curr, prev) {
                if (curr === prev) {
                    return;
                }

                this.pointer = -1;
            },
            selectedOptions(curr, prev) {
                this.$emit("input", curr);
            },
            pointer() {
                this.maybeAdjustScroll();
            }
        },
        data() {
            return {
                selectedOptions: [],
                searchText: null,
                selectedOption: null,
                dropdownOpen: false,
                closed: false,
                pointer: -1
            };
        },
        props: {
            value: {
                required: true
            },
            // Use classes to override the look and feel
            // Provide these 7 classes.
            classes: {
                type: Object,
                required: false,
                default: () => {
                    return {
                        active: "active",
                        wrapper: "multi-select-wrapper",
                        searchWrapper: "search-wrapper",
                        searchInput: "search-input",
                        pill: "pill",
                        required: "required",
                        dropdown: "dropdown"
                    };
                }
            },
            // Give your input a name
            // Good for posting forms
            name: {
                type: String,
                required: false,
                default: () => ""
            },
            // Your list of things for the select
            options: {
                type: Array,
                required: false,
                default: () => []
            },
            // Tells vue-simple-multi-select what key to use
            // for generating option labels
            optionLabel: {
                type: String,
                required: false,
                default: () => null
            },
            // Tells vue-single-select the value
            // you want populated in the select for the
            // input
            optionKey: {
                type: String,
                required: false,
                default: () => null
            },
            // Give your input an html element id
            placeholder: {
                type: String,
                required: false,
                default: () => "Search Here"
            },
            maxHeight: {
                type: String,
                default: () => "220px",
                required: false
            },
            //Give the input an id
            inputId: {
                type: String,
                default: () => "multi-select",
                required: false
            },
            // Seed search text with initial value
            initial: {
                type: String,
                required: false,
                default: () => null
            },
            // Make it required
            required: {
                type: Boolean,
                required: false,
                default: () => false
            },
            // Max number of results to show.
            maxResults: {
                type: Number,
                required: false,
                default: () => 30
            },
            //Meh
            tabindex: {
                type: String,
                required: false,
                default: () => {
                    return "";
                }
            },
            // Remove previously selected options
            // via the delete key
            keyboardDelete: {
                type: Boolean,
                required: false,
                default: () => {
                    return true;
                }
            },
            // Tell vue-single-select what to display
            // as the selected option
            getOptionDescription: {
                type: Function,
                default(option) {
                    if (this.optionKey && this.optionLabel) {
                        return option[this.optionKey] + " " + option[this.optionLabel];
                    }
                    if (this.optionLabel) {
                        return option[this.optionLabel];
                    }
                    if (this.optionKey) {
                        return option[this.optionKey];
                    }
                    return option;
                }
            },
            // Use this to actually give vue-single-select
            // a value for doing a POST
            getOptionValue: {
                type: Function,
                default(option) {
                    if (this.optionKey) {
                        return option[this.optionKey];
                    }

                    if (this.optionLabel) {
                        return option[this.optionLabel];
                    }

                    return option;
                }
            },
            readonly: {
                type: Boolean,
                required: false,
                default: () => {
                    return false;
                }
            }
        },
        methods: {
            popSelectedOption() {
                if (!this.keyboardDelete) {
                    return;
                }

                if (this.searchText === null) {
                    this.selectedOptions.pop();
                    return;
                }

                if (this.searchText === "") {
                    this.searchText = null;
                }
            },
            seedSearchText() {
                if (this.searchText !== null) {
                    return;
                }

                this.searchText = "";
            },
            setPossibleOption() {
                if (!this.matchingOptions || !this.matchingOptions.length) {
                    return;
                }

                if (this.pointer === -1) {
                    this.pointer = 0;
                }

                this.setOption(this.matchingOptions[this.pointer]);
            },
            setOption(option) {
                this.selectedOption = option;
                this.selectedOptions.push(option);
                this.searchText = null;
                this.$nextTick(() => {
                    this.$refs.search.focus();
                });
            },
            removeOption(idx) {
                this.selectedOptions.splice(idx, 1);
                this.$nextTick(() => {
                    this.$refs.search.focus();
                });
            },
            setPointerIdx(idx) {
                this.pointer = idx;
            },
            closeOut() {
                this.searchText = null;
                this.closed = true;
            },
            movePointerDown() {
                if (!this.matchingOptions) {
                    return;
                }
                if (this.pointer >= this.matchingOptions.length - 1) {
                    return;
                }

                this.pointer++;
            },
            movePointerUp() {
                if (this.pointer > 0) {
                    this.pointer--;
                }
            },
            handleClickOutside(e) {
                if (this.$el.contains(e.target)) {
                    return;
                }

                this.closeOut();
            },
            /**
             * Adjust the scroll position of the dropdown list
             * if the current pointer is outside of the
             * overflow bounds.
             * @returns {*}
             */
            maybeAdjustScroll() {
                let pixelsToPointerTop = this.pixelsToPointerTop()
                let pixelsToPointerBottom = this.pixelsToPointerBottom()

                if (pixelsToPointerTop <= this.viewport().top) {
                    return this.scrollTo(pixelsToPointerTop)
                } else if (pixelsToPointerBottom >= this.viewport().bottom) {
                    return this.scrollTo(this.viewport().top + this.pointerHeight())
                }
            },

            /**
             * The distance in pixels from the top of the dropdown
             * list to the top of the current pointer element.
             * @returns {number}
             */
            pixelsToPointerTop() {
                let pixelsToPointerTop = 0
                if (!this.$refs.options) {
                    return 0;
                }

                for (let i = 0; i < this.pointer; i++) {
                    pixelsToPointerTop += this.$refs.options.children[i].offsetHeight
                }

                return pixelsToPointerTop
            },

            /**
             * The distance in pixels from the top of the dropdown
             * list to the bottom of the current pointer element.
             * @returns {*}
             */
            pixelsToPointerBottom() {
                return this.pixelsToPointerTop() + this.pointerHeight()
            },

            /**
             * The offsetHeight of the current pointer element.
             * @returns {number}
             */
            pointerHeight() {
                let element = this.$refs.options ? this.$refs.options.children[this.pointer] : false
                return element ? element.offsetHeight : 0
            },

            /**
             * The currently viewable portion of the options.
             * @returns {{top: (string|*|number), bottom: *}}
             */
            viewport() {
                return {
                    top: this.$refs.options ? this.$refs.options.scrollTop : 0,
                    bottom: this.$refs.options ? this.$refs.options.offsetHeight + this.$refs.options.scrollTop : 0
                }
            },

            /**
             * Scroll the options to a given position.
             * @param position
             * @returns {*}
             */
            scrollTo(position) {
                return this.$refs.options ? this.$refs.options.scrollTop = position : null
            },

        },
        computed: {
            matchingOptions() {
                if (this.searchText === null) {
                    return null;
                }

                if (this.optionLabel && this.optionKey) {
                    return this.options
                        .filter(
                            option =>
                                this.selectedOptions.findIndex(
                                    selected => selected[this.optionKey] === option[this.optionKey]
                                ) < 0
                        )
                        .filter(option => {
                            return (
                                option[this.optionLabel]
                                    .toString()
                                    .toLowerCase()
                                    .includes(this.searchText.toString().toLowerCase()) ||
                                this.searchText
                                    .toString()
                                    .toLowerCase()
                                    .includes(option[this.optionKey].toString().toLowerCase())
                            );
                        })
                        .slice(0, this.maxResults);
                }

                if (this.optionLabel) {
                    return this.options
                        .filter(
                            option =>
                                this.selectedOptions.findIndex(
                                    selected =>
                                        selected[this.optionLabel] === option[this.optionLabel]
                                ) < 0
                        )
                        .filter(option =>
                            option[this.optionLabel]
                                .toString()
                                .toLowerCase()
                                .includes(this.searchText.toString().toLowerCase())
                        )
                        .slice(0, this.maxResults);
                }

                if (this.optionKey) {
                    return this.options
                        .filter(
                            option =>
                                this.selectedOptions.findIndex(
                                    selected => selected[this.optionKey] === option[this.optionKey]
                                ) < 0
                        )
                        .filter(option =>
                            option[this.optionKey]
                                .toString()
                                .toLowerCase()
                                .includes(this.searchText.toString().toLowerCase())
                        )
                        .slice(0, this.maxResults);
                }

                return this.options
                    .filter(
                        option =>
                            this.selectedOptions.findIndex(selected => selected === option) < 0
                    )
                    .filter(option =>
                        option
                            .toString()
                            .toLowerCase()
                            .includes(this.searchText.toString().toLowerCase())
                    )
                    .slice(0, this.maxResults);
            },
            isRequired() {
                if (!this.required) {
                    return "";
                }

                if (this.selectedOptions.length) {
                    return "";
                }

                return "required";
            }
        }
    };
</script>
