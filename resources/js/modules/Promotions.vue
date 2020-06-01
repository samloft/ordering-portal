<template>
    <div>
        <div class="text-right mb-5">
            <button @click="openModal()" class="button bg-gray-800 text-white">New promotion</button>
        </div>

        <div v-if="promotions.length > 0" class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Product/Value
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Promo Product/Discount
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Restriction
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Claimable
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Starts
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Ends
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <tr v-for="promotion in promotions">
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                {{ promotion.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium text-gray-900">
                                <div v-if="promotion.type === 'product'">
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{ promotion.product }}
                                    </div>
                                    <div class="text-sm leading-5 text-gray-500">Qty: {{ promotion.product_qty }}</div>
                                </div>
                                <div v-else>
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{ promotion.minimum_value
                                        }}
                                    </div>
                                    <div class="text-sm leading-5 text-gray-500">Minimum Order</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                <div
                                    v-if="promotion.type === 'product' || (promotion.type === 'value' && promotion.value_reward === 'product')">
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{
                                        promotion.promotion_product
                                        }}
                                    </div>
                                    <div class="text-sm leading-5 text-gray-500">Qty: {{ promotion.promotion_qty }}
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="text-sm leading-5 font-medium text-gray-900">
                                        {{ promotion.value_percent }}%
                                    </div>
                                    <div class="text-sm leading-5 text-gray-500">Discount
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                <span class="badge badge-info capitalize">
                                    {{ promotion.restrictions ? promotion.restrictions.replace('_', ' ') : 'none' }}
                                </span>
                                <span v-if="promotion.restrictions" class="badge badge-warning capitalize ml-1">
                                    {{ promotion[promotion.restrictions + 's'].length }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                {{ promotion.max_claims > 0 ? promotion.max_claims : 'Unlimited' }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                {{ promotion.start_date }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                {{ promotion.end_date }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                <a href="#" @click="openModal(promotion)"
                                   class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">Edit</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div v-else class="text-center underline text-xl font-medium">
            No promotions have been added yet.
        </div>

        <modal v-if="modal" title="Product Promotion">
            <div class="mb-3">
                <label for="promotion-name">Promotion Name</label>
                <input id="promotion-name" class="bg-gray-100" v-model="data.name"
                       placeholder="Promotion Name" maxlength="40">
                <span v-text="errors.get('name')" class="block text-xs text-red-600"/>
            </div>
            <div class="relative mb-3">
                <label for="type">Promotion Type</label>
                <select v-model="data.type"
                        @change="typeUpdated()"
                        id="type"
                        class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                        autocomplete="off">
                    <option value="product">Product</option>
                    <option value="value">Value</option>
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20">
                        <path
                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
                <span v-text="errors.get('type')" class="block text-xs text-red-600"/>
            </div>

            <div v-if="data.type === 'product'">
                <div class="flex mb-3">
                    <div class="w-2/3 mr-2">
                        <label for="product">Product Code</label>
                        <input id="product" class="bg-gray-100" v-model="data.product"
                               placeholder="Product code">
                        <span v-text="errors.get('product')" class="block text-xs text-red-600"/>
                    </div>

                    <div class="w-1/3">
                        <label for="product-qty">Product Quantity</label>
                        <input id="product-qty" class="bg-gray-100" v-model="data.product_qty"
                               placeholder="Minimum quantity">
                        <span v-text="errors.get('product_qty')" class="block text-xs text-red-600"/>
                    </div>
                </div>
            </div>

            <div v-if="data.type === 'value'">
                <div class="flex mb-3">
                    <div class="w-1/2 mr-1">
                        <label for="minimum-value">Min Order Value</label>
                        <input id="minimum-value" class="bg-gray-100" v-model="data.minimum_value"
                               placeholder="Order value required">
                        <span v-text="errors.get('minimum_value')" class="block text-xs text-red-600"/>
                    </div>

                    <div class="w-1/2 relative ml-1">
                        <label for="value-type">Value Reward Type</label>
                        <select v-model="data.value_reward"
                                id="value-type"
                                class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                                autocomplete="off">
                            <option value="product">Product</option>
                            <option value="percent">Discount Percent</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                        <span v-text="errors.get('value_reward')" class="block text-xs text-red-600"/>
                    </div>
                </div>

                <div v-if="data.value_reward === 'percent'">
                    <div class="mb-3">
                        <label for="value-percent">Discount Value Percent</label>
                        <input id="value-percent" class="bg-gray-100" v-model="data.value_percent"
                               placeholder="Percent to be deducted from order">
                        <span v-text="errors.get('value_percent')" class="block text-xs text-red-600"/>
                    </div>
                </div>
            </div>

            <div v-if="data.type === 'product' || (data.type === 'value' && data.value_reward === 'product')">
                <div class="flex mb-3">
                    <div class="w-2/3 mr-2">
                        <label for="promotion-product">Promotion Product</label>
                        <input id="promotion-product" class="bg-gray-100" v-model="data.promotion_product"
                               placeholder="Promotion Product">
                        <span v-text="errors.get('promotion_product')" class="block text-xs text-red-600"/>
                    </div>

                    <div class="w-1/3">
                        <label for="promotion-qty">Promotion Quantity</label>
                        <input id="promotion-qty" class="bg-gray-100" v-model="data.promotion_qty"
                               placeholder="Promotion quantity">
                        <span v-text="errors.get('promotion_qty')" class="block text-xs text-red-600"/>
                    </div>
                </div>
            </div>

            <div class="flex mb-3">
                <div class="w-1/2 relative mr-1">
                    <label for="claim-type" class="mb-0 leading-3">Claim Type</label>
                    <span class="text-xs text-gray-400">How is it claimed?</span>
                    <select v-model="data.claim_type"
                            id="claim-type"
                            class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                            autocomplete="off">
                        <option value="multiple">Multiple</option>
                        <option value="per_order">Per Order</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-9 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20">
                            <path
                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>

                <div class="w-1/2 ml-1">
                    <label for="max-claims" class="mb-0 leading-3">Maximum Claims</label>
                    <span class="text-xs text-gray-400">Leave blank for unlimited.</span>
                    <input id="max-claims" class="bg-gray-100" v-model="data.max_claims"
                           placeholder="Maximum claim amount">
                    <span v-text="errors.get('max_claims')" class="block text-xs text-red-600"/>
                </div>
            </div>

            <div class="mb-3 relative">
                <label for="customer-restrictions">Restrictions</label>
                <select v-model="data.restrictions"
                        @change="restrictionUpdate()"
                        id="customer-restrictions"
                        class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                        autocomplete="off">
                    <option value="">None</option>
                    <option value="buying_group">Buying Group</option>
                    <option value="price_list">Price List</option>
                    <option value="discount_code">Discount Code</option>
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20">
                        <path
                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>

            <div v-if="this.data.restrictions === 'buying_group'" class="mb-3">
                <label class="mb-0 leading-3">Buying Groups</label>
                <span class="text-xs text-gray-400">Select multiple buying groups.</span>
                <multi-select v-model="data.buying_groups"
                              :options="buying_groups"
                              :multiple="true"
                              :placeholder="! data.buying_groups || ! data.buying_groups.length > 0 ? 'Select buying groups' : ''"
                              readonly>
                </multi-select>
                <span v-text="errors.get('buying_groups')" class="block text-xs text-red-600"/>
            </div>

            <div v-if="this.data.restrictions === 'price_list'" class="mb-3">
                <label class="mb-0 leading-3">Price Lists</label>
                <span class="text-xs text-gray-400">Select multiple price lists.</span>
                <multi-select v-model="data.price_lists"
                              :options="price_lists"
                              :multiple="true"
                              :placeholder="! data.price_lists || ! data.price_lists.length > 0 ? 'Select price lists' : ''"
                              readonly>
                </multi-select>
                <span v-text="errors.get('price_lists')" class="block text-xs text-red-600"/>
            </div>

            <div v-if="this.data.restrictions === 'discount_code'" class="mb-3">
                <label class="mb-0 leading-3">Discount Codes</label>
                <span class="text-xs text-gray-400">Select multiple discount codes.</span>
                <multi-select v-model="data.discount_codes"
                              :options="discount_codes"
                              :multiple="true"
                              :placeholder="! data.discount_codes || ! data.discount_codes.length > 0 ? 'Select discount codes' : ''"
                              readonly>
                </multi-select>
                <span v-text="errors.get('discount_codes')" class="block text-xs text-red-600"/>
            </div>

            <div class="flex mb-3">
                <div class="mr-1">
                    <label class="mb-0 leading-3">Start Date</label>
                    <span class="text-xs text-gray-400">Valid from.</span>
                    <div class="relative date-input">
                        <flat-pickr
                            v-model="data.start_date"
                            :config="config"
                            placeholder="Select a date">
                        </flat-pickr>
                        <div v-if="data.start_date">
                            <i class="fa fa-times cursor-pointer absolute inset-y-0 right-0 flex items-center px-3 text-gray-700 pt-3"
                               title="clear" data-clear @click="data.start_date = ''">
                                <span aria-hidden="true" class="sr-only">Clear</span>
                            </i>
                        </div>
                    </div>
                    <span v-text="errors.get('start_date')" class="block text-xs text-red-600"/>
                </div>

                <div class="ml-2">
                    <label class="mb-0 leading-3">End Date</label>
                    <span class="text-xs text-gray-400">Leave blank to not end.</span>
                    <div class="relative date-input">
                        <flat-pickr
                            v-model="data.end_date"
                            :config="config"
                            placeholder="Select a date">
                        </flat-pickr>
                        <div v-if="data.end_date">
                            <i class="fa fa-times cursor-pointer absolute inset-y-0 right-0 flex items-center px-3 text-gray-700 pt-3"
                               title="clear" data-clear @click="data.end_date = ''">
                                <span aria-hidden="true" class="sr-only">Clear</span>
                            </i>
                        </div>
                    </div>
                    <span v-text="errors.get('end_date')" class="block text-xs text-red-600"/>
                </div>
            </div>

            <div class="text-right mt-3">
                <button @click="modal = false" class="button button-danger">Exit</button>
                <button v-show="data.id" @click="destroy(data.id)" class="button bg-red-600 text-white">Delete</button>
                <button @click="submit()" class="button bg-gray-700 text-white w-32">Save</button>
            </div>
        </modal>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/themes/airbnb.css';

    class Errors {
        constructor() {
            this.errors = {};
        }

        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        record(errors) {
            this.errors = errors;
        }
    }

    export default {
        props: {
            promotions: {},
            buying_groups: {},
            price_lists: {},
            discount_codes: {},
        },
        data() {
            return {
                modal: false,
                data: {},
                errors: new Errors(),
                config: {
                    wrap: true,
                    altFormat: 'd-m-Y',
                    altInput: true,
                    dateFormat: 'd-m-Y',
                },
                restrictions: {}
            }
        },
        methods: {
            openModal: function (promotion = null) {
                if (promotion) {
                    this.data = promotion;

                    this.data.restrictions = promotion.restrictions ? promotion.restrictions : '';
                } else {
                    this.data = {
                        type: 'product',
                        restrictions: '',
                        claim_type: 'multiple',
                    };
                }

                this.modal = true;
            },
            typeUpdated: function () {
                // if (this.data.type === 'value' && !this.data.value_reward) {
                //     return this.data.value_reward = 'product';
                // }
            },
            restrictionUpdate: function () {
                this.restriction = this.data.restriction;

                this.data.buying_groups = '';
                this.data.price_lists = '';
                this.data.discount_codes = '';
            },
            submit: function () {
                this.errors = new Errors();

                if (this.data.id) {
                    return this.update(this.data, this);
                }

                return this.store(this.data, this);
            },
            store: function (promotion, self) {
                axios.post('/cms/promotions', self.data).then(function (response) {
                    return Vue.swal({
                        title: "Success",
                        text: 'New promotion has been created',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'bg-gray-800 text-white'
                        }
                    }).then(response => {
                        if (response.value) {
                            return window.location.reload();
                        }
                    });
                }).catch(function (error) {
                    if (error.response.data.errors) {
                        self.errors.record(error.response.data.errors);

                        return Vue.swal({
                            title: 'Error',
                            text: 'You have failed validation, please fix the errors and try again',
                            icon: 'error',
                            confirmButtonColor: '#E02424',
                        });
                    }

                    return Vue.swal({
                        title: 'Error',
                        text: 'Unable to create promotion, please try again',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            },
            update: function (promotion, self) {
                axios.patch('/cms/promotions/' + promotion.id, promotion).then(function (response) {
                    return Vue.swal({
                        title: "Success",
                        text: 'Promotion has been updated',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'bg-gray-800 text-white'
                        }
                    }).then(response => {
                        if (response.value) {
                            return window.location.reload();
                        }
                    });
                }).catch(function (error) {
                    if (error.response.data.errors) {
                        self.errors.record(error.response.data.errors);

                        return Vue.swal({
                            title: 'Error',
                            text: 'Unable to update promotion, please fix validation errors',
                            icon: 'error',
                            confirmButtonColor: '#E02424',
                        });
                    }

                    return Vue.swal({
                        title: 'Error',
                        text: 'Unable to update promotion, please try again',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            },
            destroy: function (id) {
                Vue.swal({
                    title: 'Delete User?',
                    text: 'Are you sure? This cannot be un-done.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EAB532',
                }).then(response => {
                    if (response.value) {
                        return axios.delete('/cms/promotions/' + id).then(function (response) {
                            return Vue.swal({
                                title: "Success",
                                text: 'Promotion has been deleted',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'bg-gray-800 text-white'
                                }
                            }).then(response => {
                                if (response.value) {
                                    return window.location.reload();
                                }
                            });
                        }).catch(function (error) {
                            return Vue.swal({
                                title: 'Error',
                                text: 'Unable to delete promotion, please try again',
                                icon: 'error',
                                confirmButtonColor: '#E02424',
                            });
                        });
                    }
                }).catch(error => {
                    return Vue.swal({
                        title: 'Error',
                        text: 'Unable to delete promotion',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            }
        },
        components: {
            flatPickr
        },
    }
</script>
