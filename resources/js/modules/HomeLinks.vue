<template>
    <div>
        <div class="text-right mb-5">
            <button @click="createNewLink()" class="button bg-gray-800 text-white">
                New Category Home Link
            </button>
        </div>

        <div
            class="items-center px-4 py-6 border border-4 border-gray-800 bg-gray-200 text-gray-800 rounded-lg shadow uppercase border border-blue">
            <draggable
                :list="categories"
                class="flex flex-wrap"
                ghost-class="ghost"
                @start="dragging = true"
                @end="newOrder"
                v-if="list.length > 0"
            >
                <div
                    class="w-1/5 px-3 my-3"
                    v-for="element in categories"
                    :key="element.position"
                >
                    <div class="bg-white p-8 relative cursor-move rounded-lg hover:opacity-75">
                        <button class="py-2 px-3 bg-red-400 text-white absolute right-0 rounded-l hover:bg-red-600"
                                @click="removeCategory(element.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current"
                                 height="18" width="18">
                                <path
                                    d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/>
                            </svg>
                        </button>
                        <img class="mx-auto shadow" :src="getImage(element.image)" alt="Category Image"/>
                    </div>
                </div>
            </draggable>

            <div v-else>
                <h5 class="text-center">No category home links have been added</h5>
            </div>
        </div>

        <Transition name="fade">
            <div
                v-if="newLink"
                class="fixed inset-0 w-full h-screen flex items-center justify-center bg-smoke-dark z-50">
                <div class="relative w-full max-w-2xl bg-white shadow-lg rounded-lg p-8 text-left">
                    <div class="mb-3">
                        <label>Name</label>
                        <input class="bg-gray-100" v-model="linkData.name" placeholder="Name">
                        <span v-text="errors.get('name')" class="text-sm text-red-600"/>
                    </div>

                    <div class="relative mb-3">
                        <label>URL <small>(Top Level)</small></label>
                        <select @change="topSelected(linkData.topLevelValue)"
                                class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                                autocomplete="off"
                                v-model="linkData.topLevelValue"
                        >
                            <option v-for="category in toplevel">{{ category.level_1 }}</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                        <span v-text="errors.get('url')" class="text-sm text-red-600"/>
                    </div>

                    <div v-show="secondLevelValues" class="relative mb-3">
                        <label>URL <small>(Second Level)</small></label>
                        <select @change="secondSelected(linkData.topLevelValue, linkData.secondLevelValue)"
                            class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                            autocomplete="off"
                        v-model="linkData.secondLevelValue">
                            <option v-for="category in secondLevelValues">{{ category.level_2 }}</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>

                    <div v-show="thirdLevelValues" class="relative mb-3">
                        <label>URL <small>(Third Level)</small></label>
                        <select
                            class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                            autocomplete="off"
                        v-model="linkData.thirdLevelValue">
                            <option v-for="category in thirdLevelValues">{{ category.level_3 }}</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Image File</label>
                        <label
                            class="flex items-center justify-center p-2 bg-gray-800 text-gray-100 rounded-lg shadow border border-blue cursor-pointer hover:opacity-75">
                            <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                            </svg>
                            <span class="ml-4 font-thin uppercase tracking-widest">Select a image</span>
                            <input type='file' class="hidden" accept="image/*"
                                   @change="imageAdded($event.target.files[0])"/>
                        </label>
                        <span v-text="errors.get('file')" class="text-sm text-red-600"/>
                    </div>

                    <img v-if="imageFile" :src="imageFile" class="mb-3 shadow mx-auto" alt="Image Upload"/>

                    <div class="mt-8 text-right">
                        <button @click="newLink = false" class="button button-danger">Cancel</button>
                        <button @click="submit()" class="button bg-gray-800 text-white">Create</button>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script>
    import draggable from "vuedraggable";

    class Errors {
        constructor() {
            this.errors = {};
        }

        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        record(errors) {
            this.errors = errors;
        }
    }

    export default {
        order: 0,
        components: {
            draggable
        },
        props: {
            list: Array,
            toplevel: Array,
        },
        data() {
            return {
                errors: new Errors(),
                newLink: false,
                linkData: {},
                dragging: false,
                imageFile: null,
                form: new FormData(),
                categories: this.list,
                secondLevelValues: null,
                thirdLevelValues: null,
            };
        },
        methods: {
            newOrder: function () {
                this.categories.forEach(function (item, key) {
                    item.position = key;
                });

                axios.patch('/cms/home-links/update-positions', this.categories)
                    .catch(error => {
                        Vue.swal('Error', 'Unable to update category positions, please try again', 'error');
                    });

                console.log(JSON.stringify(this.categories));
            },
            getImage(image) {
                return '/images/home-links/' + image;
            },
            imageAdded(file) {
                this.form.append('file', file);
                this.imageFile = URL.createObjectURL(file);
            },
            createNewLink() {
                this.errors = new Errors;
                this.linkData = {};
                this.imageFile = null;

                this.secondLevelValues = null;
                this.thirdLevelValues = null;

                this.newLink = true;
            },
            submit() {
                this.form.append('name', this.linkData.name ? this.linkData.name : '');

                var urlSegment = this.linkData.topLevelValue ? '/products/' + this.linkData.topLevelValue : '';
                var urlSegment2 = this.linkData.secondLevelValue ? '/' + this.linkData.secondLevelValue : '';
                var urlSegment3 = this.linkData.thirdLevelValue ? '/' + this.linkData.thirdLevelValue : '';

                this.form.append('url', urlSegment + urlSegment2 + urlSegment3);
                this.form.append('position', (this.categories.length + 1));

                axios.post('/cms/home-links', this.form).then(response => {
                    this.newLink = false;

                    Vue.swal('success', 'New category home link has been created', 'success');

                    this.categories.push(response.data.data);
                }).catch(error => this.errors.record(error.response.data.errors));
            },
            removeCategory(id) {
                var vm = this;

                Vue.swal({
                    title: 'Delete Category Link?',
                    text: 'Are you sure? This cannot be un-done.',
                    type: 'warning',
                    showCancelButton: true,
                }).then(response => {
                    if (response.value) {
                        axios.delete('/cms/home-links/' + id).then(response => {
                            let i = vm.categories.map(item => item.id).indexOf(id);
                            vm.categories.splice(i, 1);

                            return Vue.swal('Success', 'Category home link has been deleted', 'success');
                        }).catch(error => {
                            return Vue.swal('Error', 'Unable to delete category image, please try again', 'error');
                        })
                    }
                });
            },
            topSelected(category) {
                this.secondLevelValues = null;
                this.linkData.secondLevelValue = '';
                this.thirdLevelValues = null;
                this.linkData.thirdLevelValue = '';

                axios.post('/cms/home-links/categories/' + category).then(response => {
                    this.secondLevelValues = response.data;
                }).catch(error => {
                    Vue.swal('Error', 'Unable to get categories', 'error');
                })
            },
            secondSelected(category1, category2) {
                this.thirdLevelValues = null;
                this.linkData.thirdLevelValue = '';

                axios.post('/cms/home-links/categories/' + category1 + '/' + category2).then(response => {
                    this.thirdLevelValues = response.data;
                }).catch(error => {
                    Vue.swal('Error', 'Unable to get categories', 'error');
                })
            }
        }
    };
</script>