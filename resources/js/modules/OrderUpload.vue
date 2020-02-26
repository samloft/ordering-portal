<template>
    <div class="">
        <div class="input-wrap border border-brand-primary rounded-lg p-5 mb-5 hover:bg-gray-100">
            <label class="custom-file-label">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-16 mx-auto icon-cloud-upload">
                    <path class="bg-primary fill-current opacity-50"
                          d="M18 14.97c0-.76-.3-1.51-.88-2.1l-3-3a3 3 0 0 0-4.24 0l-3 3A3 3 0 0 0 6 15a4 4 0 0 1-.99-7.88 5.5 5.5 0 0 1 10.86-.82A4.49 4.49 0 0 1 22 10.5a4.5 4.5 0 0 1-4 4.47z"></path>
                    <path class="bg-primary fill-current"
                          d="M11 14.41V21a1 1 0 0 0 2 0v-6.59l1.3 1.3a1 1 0 0 0 1.4-1.42l-3-3a1 1 0 0 0-1.4 0l-3 3a1 1 0 0 0 1.4 1.42l1.3-1.3z"></path>
                </svg>
                Click here to select CSV file<span>{{ fileName }}</span></label>
            <input type="file" id="order-file" name="csv_file" @change="updateFileName">
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
