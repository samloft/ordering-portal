<template>
    <div class="form-row justify-content-center mb-5">
        <div class="input-group input-wrap">
            <label class="custom-file-label"><i class="fa fa-file-upload"></i> Click here to select CSV file<span>{{ fileName }}</span></label>
            <input type="file" id="order-file" class="border-2 border-brand-primary" name="csv_file" @change="updateFileName">
        </div>

        <div class="text-right">
            <button id="upload-order" class="button button-primary">Upload Order
                <i class="fa fa-download"></i>
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
            updateFileName(event){
                this.fileName = event.target.files[0].name;
            }
        }
    }
</script>
