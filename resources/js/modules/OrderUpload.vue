<template>
    <div>
        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md mb-5 relative">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <p class="mt-1 text-sm text-gray-600">
                    <button type="button"
                            class="font-medium text-brand-primary hover:underline focus:outline-none focus:underline transition duration-150 ease-in-out">
                        Click to upload a CSV file
                    </button>
                    or drag and drop one here
                </p>
                <p class="mt-1 text-xs font-thin text-gray-500">
                    {{ fileName }}
                </p>

                <input type="file" id="order-file" name="csv_file" class="absolute h-48 left-0 top-0 opacity-0" @change="updateFileName">
            </div>
        </div>

        <div class="text-right">
            <button id="upload-order" class="button button-primary">Upload Order
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 ml-3 icon inline">
                    <path class="primary"
                          d="M8 4a1 1 0 0 1-1 1H5v10h2a2 2 0 0 1 2 2c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2c0-1.1.9-2 2-2h2V5h-2a1 1 0 0 1 0-2h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h2a1 1 0 0 1 1 1z"></path>
                    <path class="secondary"
                          d="M11 6.41V13a1 1 0 0 0 2 0V6.41l1.3 1.3a1 1 0 0 0 1.4-1.42l-3-3a1 1 0 0 0-1.4 0l-3 3a1 1 0 0 0 1.4 1.42L11 6.4z"></path>
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fileName: 'No file selected'
            }
        },
        methods: {
            updateFileName(event) {
                this.fileName = event.target.files[0].name;
            }
        }
    }
</script>
