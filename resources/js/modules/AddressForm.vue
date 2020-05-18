<template>
    <div>
        <div class="md:flex items-center">
            <label for="postcode_lookup" class="md:w-2/6">Postcode Lookup</label>
            <div class="flex w-full">
                <input id="postcode_lookup" class="flex-1 bg-gray-100 rounded-none rounded-l-md"
                       placeholder="Add a postcode to lookup address"
                       v-model="postcode_lookup"
                       name="lookup">
                <button @click="lookup()"
                        type="button"
                        :disabled="searching"
                        :class="searching ? 'cursor-disabled opacity-75' : 'cursor-pointer'"
                        class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-button-primary_color text-button-primary_text sm:text-sm hover:opacity-75">
                    {{ searching ? 'Searching' : 'Lookup' }}
                    <svg v-if="searching" xmlns="http://www.w3.org/2000/svg"
                         width="20px" height="20px" viewBox="0 0 40 40" enable-background="new 0 0 40 40"
                         xml:space="preserve" class="ml-3">
                              <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                                  s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                                  c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
                        <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                                  C22.32,8.481,24.301,9.057,26.013,10.047z">
                                <animateTransform attributeType="xml"
                                                  attributeName="transform"
                                                  type="rotate"
                                                  from="0 20 20"
                                                  to="360 20 20"
                                                  dur="0.5s"
                                                  repeatCount="indefinite"/>
                              </path>
                            </svg>
                </button>
            </div>
        </div>

        <div class="mt-3" v-if="Object.keys(addresses).length > 0">
            <span class="text-gray-500 text-center w-full block text-sm">Select an address from the list below to auto-populate</span>

            <div class="md:flex items-center mt-3">
                <label for="addresses" class="md:w-2/6">Address List</label>
                <select id="addresses" class="ml-1 block form-select text-sm bg-gray-100"
                        v-model="selected_address"
                        @change="addressSelected(selected_address)">
                    <option value="">Select an address</option>
                    <option v-for="address in addresses.addresses">{{ address }}
                    </option>
                </select>
            </div>
        </div>

        <hr class="mb-5 mt-5">

        <slot name="form" :selected_address="address" :postcode="postcode_lookup.toUpperCase()"></slot>
    </div>
</template>

<script>
    export default {
        props: {
            editing: false,
        },
        data() {
            return {
                postcode_lookup: '',
                addresses: {},
                selected_address: '',
                address: '',
                searching: false,
            }
        },
        methods: {
            async lookup() {
                let self = this;

                this.searching = true;
                this.addresses = {};

                await axios.get('/account/addresses/lookup/', {
                    params: {
                        postcode: this.postcode_lookup
                    }
                }).then(function (response) {
                    self.addresses = response.data;
                }).catch(function (error) {
                    if (!error.response) {
                        return;
                    }

                    let status = error.response.status;
                    let message;

                    if (status === 422) {
                        message = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                    } else if (status === 404) {
                        message = 'Postcode could not be found, please try again';
                    } else if (status === 400) {
                        message = 'That is not a valid postcode, please search valid postcodes only';
                    } else {
                        message = 'Unable to lookup postcode, please try again';
                    }

                    return Vue.swal({
                        title: 'Error',
                        text: message,
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });

                this.searching = false;
            },
            addressSelected(addressSelected) {
                addressSelected = addressSelected.split(',');

                this.address = {
                    line_1: addressSelected[0],
                    town_or_city: addressSelected[5],
                    locality: addressSelected[4],
                    county: addressSelected[6],
                };
            }
        }
    }
</script>
