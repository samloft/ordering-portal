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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                report_type: '',
                output_type: 'pdf',
            }
        },
        methods: {
            async downloadReport() {
                if (!this.report_type) {
                    Vue.swal({
                        title: 'Error',
                        text: 'You must select a report to download',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                }

                if(!this.output_type) {
                    Vue.swal({
                        title: 'Error',
                        text: 'You must select an output type',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                }

                var vm = this;

                Vue.swal({
                    title: 'Preparing report.....',
                    text: 'Please wait while we crunch the data and prepare your download.',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    icon: 'info',
                });

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
                    Vue.swal({
                        title: 'Error',
                        text: 'Unable to generate report, please try again',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });

                Vue.swal.close();
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
