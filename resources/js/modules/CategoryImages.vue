<template>
    <div>
        <div class="text-right mb-5">
            <button @click="showModal()" class="button bg-gray-800 text-white">New category image override</button>
        </div>

        <div v-if="images.length > 0">
            <table class="w-full text-md bg-white shadow-md rounded mb-4">
                <tbody>
                <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
                    <th class="font-semibold p-3 px-5">Image</th>
                    <th class="font-semibold p-3 px-5">Level 1</th>
                    <th class="font-semibold p-3 px-5">Level 2</th>
                    <th class="font-semibold p-3 px-5">Level 3</th>
                    <th class="font-semibold p-3 px-5"></th>
                    <th></th>
                </tr>
                <tr v-for="image in images" class="border-b hover:bg-gray-100" :key="image.id">
                    <td class="p-3 px-5">
                        <img :src="s3 + company + '/category_images/' + image.image" :alt="image.image" class="h-16">
                    </td>
                    <td class="p-3 px-5">{{ image.level_1 }}</td>
                    <td class="p-3 px-5">{{ image.level_2 }}</td>
                    <td class="p-3 px-5">{{ image.level_3 }}</td>
                    <td class="p-3 px-5 text-right">
                        <button @click="destroy(image.id)" type="button"
                                class="button bg-red-600 text-white text-xs w-20">Delete
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="text-center p-6 border border-gray-200 rounded bg-gray-100">
            <span class="font-semibold text-lg tracking-widest">No category image overrides have been added</span>
        </div>

        <modal v-if="modal">
            <div class="relative mb-3">
                <label>Level 1 Category</label>
                <select @change="topSelected(imageData.level_1)"
                        class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                        autocomplete="off"
                        v-model="imageData.level_1"
                >
                    <option v-for="category in categories.level_1">{{ category.level_1 }}</option>
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20">
                        <path
                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
                <span v-text="errors.get('level_1')" class="text-sm text-red-600"/>
            </div>

            <div v-show="imageData.level_1" class="relative mb-3">
                <label>Level 2 Category</label>
                <select @change="secondSelected(imageData.level_1, imageData.level_2)"
                        class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                        autocomplete="off"
                        v-model="imageData.level_2">
                    <option v-for="category in secondLevel">{{ category.level_2 }}</option>
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

            <div v-show="imageData.level_2" class="relative mb-3">
                <label>Level 3 Category</label>
                <select
                    class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                    autocomplete="off"
                    v-model="imageData.level_3">
                    <option v-for="category in thirdLevel">{{ category.level_3 }}</option>
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

            <img v-if="imageFile" :src="imageFile" class="mb-3 shadow mx-auto h-48" alt="Image Upload"/>

            <div class="mt-8 text-right">
                <button @click="closeModal()" class="button button-danger">Cancel</button>
                <button @click="submit()" class="button bg-gray-800 text-white">Create</button>
            </div>
        </modal>
    </div>
</template>

<script>
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
        props: {
            category_images: {},
            top_categories: {},
            company: null,
            s3: null,
        },
        data() {
            return {
                errors: new Errors(),
                form: new FormData(),
                images: {},
                imageFile: null,
                categories: {},
                imageData: {},
                modal: false,
                secondLevel: {},
                thirdLevel: {},
            }
        },
        methods: {
            topSelected(category) {
                this.secondLevel = {};
                this.thirdLevel = {};

                axios.post('/cms/home-links/categories/' + category).then(response => {
                    this.secondLevel = response.data;
                }).catch(error => {
                    return Vue.swal({
                        title: 'Error',
                        text: 'Unable to get categories',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            },
            secondSelected(category1, category2) {
                this.thirdLevel = {};

                axios.post('/cms/home-links/categories/' + category1 + '/' + category2).then(response => {
                    this.thirdLevel = response.data;
                }).catch(error => {
                    return Vue.swal({
                        title: 'Error',
                        text: 'Unable to get categories',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            },
            showModal() {
                this.imageData = {
                    level_1: '',
                    level_2: '',
                    level_3: '',
                };

                this.modal = true;
            },
            closeModal() {
                window.location.reload();
            },
            imageAdded(image) {
                this.form.append('file', image);
                this.imageFile = URL.createObjectURL(image);
            },
            submit() {
                this.form.append('level_1', this.imageData.level_1);
                this.form.append('level_2', this.imageData.level_2);
                this.form.append('level_3', this.imageData.level_3);

                axios.post('/cms/category-images/store', this.form).then(response => {
                    return Vue.swal({
                        title: "Success",
                        text: 'New category override image has been created',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'bg-gray-800 text-white'
                        }
                    });
                }).catch(error => {
                    if (error.response.data.errors) {
                        return this.errors.record(error.response.data.errors);
                    }

                    return Vue.swal({
                        title: 'Error',
                        text: 'An unknown error occurred',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            },
            destroy(id) {
                var vm = this;

                Vue.swal({
                    title: 'Delete image override?',
                    text: 'Are you sure? This cannot be un-done.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EAB532',
                }).then(response => {
                    if (response.value) {
                        axios.delete('/cms/category-images/' + id).then(response => {
                            let i = vm.images.map(item => item.id).indexOf(id);
                            vm.images.splice(i, 1);

                            return Vue.swal({
                                title: "Success",
                                text: 'Category override has been deleted',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'bg-gray-800 text-white'
                                }
                            });
                        }).catch(error => {
                            return Vue.swal({
                                title: 'Error',
                                text: 'Unable to delete category override, please try again',
                                icon: 'error',
                                confirmButtonColor: '#E02424',
                            });
                        })
                    }
                });
            },
        },
        mounted() {
            this.images = this.category_images;
            this.categories.level_1 = this.top_categories;
        }
    }
</script>
