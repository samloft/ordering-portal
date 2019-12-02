<template>
    <div class="">
        <div class="input-wrap border border-brand-primary rounded-lg p-5 mb-5 hover:bg-gray-100">
            <label class="custom-file-label"><i class="fa fa-file-upload"/> Click here to select CSV file<span>{{ fileName }}</span></label>
            <input type="file" id="order-file" name="csv_file" @change="updateFileName">
        </div>

        <div class="text-right">
            <button id="upload-order" class="button button-primary">Upload Order
                <i class="fa fa-download"/>
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
