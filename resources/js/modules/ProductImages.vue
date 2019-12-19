<template>
    <div class="flex">
        <div class="w-1/3 mr-5">
            <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-8 xl:pb-8 bg-white rounded-lg shadow">
                <button @click="checkMissingImages()" class="button button-block bg-gray-800 text-white relative"
                        :disabled="checkingImages">
                    {{ checkingImages ? 'Searching...' : 'Search missing products' }}
                    <span :class="checkingImages ? 'loadingSpinner' : ''"/>
                </button>

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

            </div>
        </div>
    </div>
</template>

<style>
    .table-container {
        max-height: 500px;
        overflow: auto;
    }
</style>

<script>
    export default {
        data() {
            return {
                checkingImages: false,
                missingImages: [],
                checkComplete: false
            }
        },
        methods: {
            checkMissingImages: function () {
                this.checkingImages = true;
                this.checkComplete = false;

                axios.get('/cms/product-images/missing').then(response => {
                    this.missingImages = response.data;

                    this.checkComplete = true;
                    this.checkingImages = false;
                });
            }
        }
    }
</script>
