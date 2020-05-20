<template>
    <div class="flex">
        <div class="w-1/3 mr-5">
            <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-8 xl:pb-8 bg-white rounded-lg shadow">
                <button @click="checkMissingImages()" class="button button-block bg-gray-800 text-white relative"
                        :disabled="checkingImages">
                    {{ checkingImages ? 'Searching...' : 'Search missing products' }}
                    <span :class="checkingImages ? 'loadingSpinner' : ''"/>
                </button>

                <div v-show="missingImagesCount > 0" role="alert" class="alert alert-info mt-5">
                    <div class="alert-body text-sm leading-none items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                            <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z" class="primary"/>
                            <path
                                d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
                                class="secondary"/>
                        </svg>
                        <div>
                            <p class="alert-text">Currently <span class="font-medium">{{ missingImagesCount }}</span> images are missing...</p>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <table v-if="missingImages.length > 0" class="mt-5 w-full text-md bg-white shadow-md rounded">
                        <thead>
                        <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
                            <th class="font-semibold p-3 px-5">Product</th>
                            <th class="font-semibold p-3 px-5">Required Image</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="missingImage in missingImages" class="border-b hover:bg-gray-100">
                            <td class="p-3 px-5">{{ missingImage.product }}</td>
                            <td class="p-3 px-5"><span class="badge badge-info">{{ missingImage.file_name }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="missingImages.length === 0 && checkComplete">
                    <div class="alert alert-success mt-5" role="alert">
                        <div class="alert-body">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                                <circle cx="12" cy="12" r="10" class="primary"/>
                                <path class="secondary"
                                      d="M10 14.59l6.3-6.3a1 1 0 0 1 1.4 1.42l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 0 1 1.4-1.42l2.3 2.3z"/>
                            </svg>
                            <div>
                                <p class="alert-title">Great Stuff!</p>
                                <p class="alert-text">No Missing images have been found!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-2/3">
            <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-8 xl:pb-8 bg-white rounded-lg shadow">
                    <h1 class="uppercase tracking-widest mb-3 text-xl font-medium">
                        Upload product images
                    </h1>

                    <label id="dropzone"
                        class="flex flex-col items-center px-4 py-6 border-dashed border-4 border-gray-800 bg-gray-200 text-gray-800 rounded-lg shadow tracking-widest uppercase border border-blue cursor-pointer hover:opacity-75">
                        <svg class="w-20 h-20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20">
                            <path
                                d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                        </svg>
                        <span class="mt-5 text-base leading-normal">Drag your file(s) here or click to browse</span>
                        <input type='file' class="hidden" multiple
                               @change="prepareUploads($event.target.files)"
                        />
                    </label>

                <div v-if="uploadsCompleted" class="bg-gray-800 text-white rounded mt-5 p-5 flex text-center">
                    <div class="font-semibold tracking-widest w-1/2">Uploaded: <span class="font-normal tracking-normal">{{ imagesUploaded }} / {{ totalImages }}</span></div>
                    <div class="font-semibold tracking-widest w-1/2">Failed: <span class="font-normal tracking-normal">{{ imagesFailed }}</span></div>
                </div>

                <div v-if="uploading" class="image-table-container">
                    <table v-if="files.length > 0" class="mt-5 w-full text-md bg-white shadow rounded">
                        <thead>
                        <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
                            <th/>
                            <th class="font-semibold p-3 px-5">File Name</th>
                            <th class="font-semibold p-3 px-5">Size</th>
                            <th class="font-semibold p-3 px-5">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="file in files" class="border-b hover:bg-gray-100">
                            <td><img class="h-8 mx-auto" :src="file.image" :alt="file.name"></td>
                            <td class="p-3 px-5">{{ file.name }}</td>
                            <td class="p-3 px-5"><span class="badge badge-info">{{ file.size }}</span></td>
                            <td class="p-3 px-5">
                                <div class="flex items-start">
                                <span class="badge inline-block flex items-center"
                                      :class="[
                                          file.status === 'error' ? 'badge-danger' : '',
                                          file.status === 'pending' ? 'badge-warning' : '',
                                          file.status === 'uploading' ? 'badge-info' : '',
                                          file.status === 'uploaded' ? 'badge-success' : '',
                                          ]">
                                    <span
                                        :class="file.status === 'uploading' ? 'loadingSpinner inline-block' : ''"/><span
                                    class="relative">{{ file.message }}</span>
                                </span>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .table-container {
        max-height: 500px;
        overflow: auto;
    }

    .image-table-container {
        max-height: 700px;
        overflow: auto;
    }
</style>

<script>
    export default {
        data() {
            return {
                checkingImages: false,
                missingImages: [],
                missingImagesCount: 0,
                checkComplete: false,
                uploading: false,
                fileList: [],
                files: [],
                totalImages: 0,
                imagesUploaded: 0,
                imagesFailed: 0,
                uploadsCompleted: false,
            }
        },
        methods: {
            checkMissingImages: function () {
                this.missingImagesCount = 0;
                this.checkingImages = true;
                this.checkComplete = false;
                this.missingImages = [];

                axios.get('/cms/product-images/missing').then(response => {
                    this.missingImages = response.data;
                    this.missingImagesCount = response.data.length;

                    this.checkComplete = true;
                    this.checkingImages = false;
                }).catch(error => {
                    this.checkingImages = false;
                    this.checkComplete = true;

                    if(error.response.status === 504) {
                        return Vue.swal({
                            title: 'Error',
                            text: 'The request timed out',
                            icon: 'error',
                            confirmButtonColor: '#E02424',
                        });
                    }

                    return Vue.swal({
                        title: 'Error',
                        text: 'An error occurred, unable to check missing images',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            },
            prepareUploads: function (files) {
                this.uploadsCompleted = false;
                this.imagesUploaded = 0;
                this.imagesFailed = 0;

                var re = /(?:\.([^.]+))?$/;
                var status = 'pending';

                this.uploading = true;

                Array.from(files).forEach(file => {
                    if (re.exec(file.name)[1] === 'png') {
                        status = 'pending';

                        this.totalImages++;
                    } else {
                        status = 'error';
                    }

                    var formData = new FormData();
                    formData.append('file', file);

                    this.files.push({
                        form: formData,
                        image: URL.createObjectURL(file),
                        name: file.name,
                        size: App.humanFileSize(file.size, true),
                        status: status,
                        message: status === 'pending' ? 'Pending' : 'File must be png'
                    });
                });

                this.uploadImages();
            },
            uploadImages: function() {
                this.files.forEach(file => {
                    if (file.status === 'pending') {
                        file.status = 'uploading';
                        file.message = 'Uploading';

                        axios.post('/cms/product-images', file.form, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(response => {
                            this.imagesUploaded++;
                            file.status = 'uploaded';
                            file.message = 'Completed';
                        }).catch(error => {
                            this.status = 'error';
                            this.message = 'Failed to upload';
                            this.imagesFailed++;
                        });
                    }
                });

                this.uploadsCompleted = true;
            }
        },
        mounted() {
            var self = this;

            document.querySelector('#dropzone').addEventListener("dragleave", function (e) {
                e.preventDefault();
            });

            document.querySelector('#dropzone').addEventListener("dragover", function (e) {
                e.preventDefault();
            });

            document.querySelector('#dropzone').addEventListener("drop", function (e) {
                e.preventDefault();

                self.prepareUploads(e.dataTransfer.files);
            });
        }
    }
</script>
