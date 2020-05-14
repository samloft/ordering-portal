<template>
    <div>
        <label class="checkbox flex items-center justify-center mb-1">
            <input type="radio" class="form-checkbox" name="report" value="account_summary" v-model="report_type">
            <span class="ml-2">Account Summary</span>
        </label>

        <label class="checkbox flex items-center justify-center">
            <input type="radio" class="form-checkbox" name="report" value="back_orders" v-model="report_type">
            <span class="ml-2">Back Order History</span>
        </label>

        <div class="relative mt-3 w-40 mx-auto">
            <label for="output">Output As </label>
            <select id="output" class="w-full p-2 rounded border text-gray-600 appearance-none" name="output"
                    v-model="output_type">
                <option value="pdf">PDF</option>
                <option value="csv">CSV</option>
            </select>

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>

        <button class="button button-primary mt-5" @click="downloadReport()">Run Report</button>

        <modal v-if="downloading">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8 16C5.23858 16 3 13.7614 3 11C3 8.55154 4.75992 6.51413 7.08376 6.08376C7.51412 3.75992 9.55154 2 12 2C14.4485 2 16.4859 3.75992 16.9162 6.08376C19.2401 6.51413 21 8.55154 21 11C21 13.7614 18.7614 16 16 16M9 19L12 22M12 22L15 19M12 22V10"
                        stroke="#4A5568" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Preparing report.....
                </h3>
                <div class="mt-2">
                    <p class="text-sm leading-5 text-gray-500">
                        Please wait while we crunch the data and prepare your download.
                    </p>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                downloading: false,
                report_type: '',
                output_type: 'pdf',
            }
        },
        methods: {
            async downloadReport() {
                if (!this.report_type) {
                    return Vue.swal('Error', 'You must select a report to download', 'error');
                }

                if(!this.output_type) {
                    return Vue.swal('Error', 'You must select n output type', 'error');
                }

                this.downloading = true;
                var vm = this;

                await axios({
                    method: 'post',
                    url: '/reports/show',
                    data: {
                        report: vm.report_type,
                        output: vm.output_type,
                    },
                    responseType: 'arraybuffer'
                }).then(function (response) {
                    var filename = response.headers['content-disposition'].split('filename=')[1];

                    return vm.forceFileDownload(response, filename);
                }).catch(function (error) {
                    return Vue.swal('Error', 'Unable to generate report, please try again', 'error');
                });

                this.downloading = false;
            },
            forceFileDownload(response, filename) {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');

                link.href = url;
                link.setAttribute('download', filename.replace(/['"]+/g, ''));
                document.body.appendChild(link);

                link.click();
                link.remove();
            },
        },
    }
</script>
