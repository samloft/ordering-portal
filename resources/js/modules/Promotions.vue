<template>
    <div>
        <div class="text-right mb-5">
            <button @click="openModal()" class="button bg-gray-800 text-white">New promotion</button>
        </div>

        <div v-if="data.length > 0" class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Qty
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Promo Product
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Promo Qty
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Claimable
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium text-gray-900">
                                Bernard Lane
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                Director, Human Resources
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                bernardlane@example.com
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                Owner
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                Owner
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                <a href="#"
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

        <fade-transition>
            <div v-if="modal"
                 class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center z-50">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div
                    class="bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3">
                            Product Promotion
                        </h3>
                        <div class="mb-3">
                            <label for="product">Product Code</label>
                            <input id="product" class="bg-gray-100" v-model="data.product"
                                   placeholder="Product code that customers need to buy">
                            <span v-text="errors.get('product')" class="block text-sm text-red-600"/>
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button @click="modal = false" class="button button-danger">Exit</button>
                        <!--                        <button v-show="editing" @click="destroy(data.id)" class="button bg-red-600 text-white">Delete-->
                        <!--                        </button>-->
                        <button class="button bg-gray-700 text-white w-32">Save</button>
                    </div>
                </div>
            </div>
        </fade-transition>
    </div>
</template>

<script>
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
        },
        data() {
            return {
                modal: false,
                data: {},
                errors: new Errors(),
            }
        },
        methods: {
            openModal: function () {
                this.modal = true;
            }
        },
        mounted() {
            this.data = this.promotions;
        }
    }
</script>
