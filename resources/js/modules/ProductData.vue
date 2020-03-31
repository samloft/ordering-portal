<template>
    <div>
        <div v-if="product_data.prices" class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow mb-4">
            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Net price list</h5>
                    <p class="text-gray-600 text-sm">
                        Pricing information showing net price and net price excluding any ordering discount.
                    </p>
                </div>
                <div class="w-3/4 flex">
                    <div class="w-1/2 relative mr-1">
                        <label for="product-brand" class="text-sm font-medium">Brand</label>
                        <select id="product-brand" class="rounded border bg-gray-100 text-gray-600 appearance-none mt-1"
                                autocomplete="off"
                                v-model="brand"
                                @change="brandChanged()">
                            <option value="">Select all</option>
                            <option v-for="brand in brands" :value="brand.level_1">{{ brand.level_1 }}</option>
                        </select>
                        <div
                            class="pointer-events-none absolute top-0 right-0 flex px-3 pt-9 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="w-1/2 relative ml-1">
                        <label for="product-range" class="text-sm font-medium">Range</label>
                        <select id="product-range" class="rounded border bg-gray-100 text-gray-600 appearance-none mt-1"
                                autocomplete="off"
                                v-model="range">
                            <option value="">Select all</option>
                            <option v-for="range in ranges" :value="range.level_2">{{ range.level_2 }}</option>
                        </select>
                        <div
                            class="pointer-events-none absolute top-0 right-0 flex px-3 pt-9 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <button @click="downloadPrices()" class="button button-primary">Download net price list</button>
            </div>
        </div>

        <div v-if="product_data.data" class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Product Data</h5>
                    <p class="text-gray-600 text-sm">
                        Complete product data will provide a Excel file with the following data.
                        <br><br>
                        Product Code, Description, category's, Box Quantities, Selling Factor, Barcode's, Trade Price,
                        dimensions, weights, image URLs
                    </p>
                </div>
                <div class="w-3/4 text-right">
                    <button @click="downloadData()" class="button button-primary">Download product data</button>
                </div>
            </div>
        </div>

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
                    Preparing download.....
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
        props: {
            brands: {},
            product_data: {},
        },
        data() {
            return {
                ranges: [],
                brand: '',
                range: '',
                downloading: false,
            }
        },
        methods: {
            brandChanged: function () {
                this.range = '';
                this.ranges = [];

                axios.get('/product-data/range/' + this.brand).then(response => {
                    this.ranges = response.data;
                }).catch(error => {
                    Vue.swal('Error', 'Unable to get ranges, please try again', 'error');
                });
            },
            async downloadPrices() {
                this.downloading = true;
                var vm = this;

                await axios({
                    method: 'get',
                    url: '/product-data/prices?brand=' + this.brand + '&range=' + this.range,
                    responseType: 'arraybuffer'
                }).then(function (response) {
                    vm.forceFileDownload(response, 'product-net-prices.xlsx');
                }).catch(function (error) {
                    console.log(error);
                    Vue.swal('Error', 'Unable to generate downloadable file, please try again');
                });

                this.downloading = false;
            },
            async downloadData() {
                this.downloading = true;
                var vm = this;

                await axios({
                    method: 'get',
                    url: '/product-data/data',
                    responseType: 'arraybuffer'
                }).then(function (response) {
                    vm.forceFileDownload(response, 'product-data.xlsx');
                }).catch(function (error) {
                    console.log(error);
                    Vue.swal('Error', 'Unable to generate downloadable file, please try again');
                });

                this.downloading = false;
            },
            forceFileDownload(response, fileName) {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');

                link.href = url;
                link.setAttribute('download', fileName);
                document.body.appendChild(link);

                link.click();
                link.remove();
            },
        },
    }
</script>
