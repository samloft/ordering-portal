<template>
    <div>
        <div class="text-right mb-3">
            <button @click="customer_discount_modal = true" class="button bg-gray-800 text-white">New discount
                override
            </button>
        </div>

        <table v-if="customer_discounts.length > 0" class="w-full text-md bg-white shadow-md rounded mb-4">
            <tbody>
            <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
                <th class="font-semibold p-2 px-5">Customer Code</th>
                <th class="font-semibold p-2 px-5">Customer Name</th>
                <th class="font-semibold p-2 px-5">Discount Percent</th>
                <th></th>
            </tr>
            <tr v-for="(discount, key) in customer_discounts" class="border-b hover:bg-gray-100">
                <td class="p-1 px-5">{{ discount.customer_code }}</td>
                <td class="p-1 px-5">{{ discount.customer.name }}</td>
                <td class="p-1 px-5">
                    <span class="badge badge-info">{{ discount.percent }}%</span>
                </td>
                <td class="p-1 px-5 flex justify-end">
                    <button @click="edit(discount.id, discount.customer_code, discount.percent, key)" type="button"
                            class="button bg-gray-700 text-white text-xs w-20">
                        Edit
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-else>
            <h4 class="text-center text-xl underline">No customer discount overrides have been added yet.</h4>
        </div>

        <Transition name="fade">
            <div
                v-if="customer_discount_modal"
                class="fixed inset-0 w-full h-screen flex items-center justify-center bg-smoke-dark z-50">
                <div class="relative w-full max-w-2xl bg-white shadow-lg rounded-lg p-8 text-left">
                    <div class="mb-3">
                        <label>Customer Code</label>
                        <input class="bg-gray-100" v-model="data.customer_code" placeholder="Customer Code"
                               :readonly="editing" v-uppercase>
                        <span v-text="errors.get('customer_code')" class="text-sm text-red-600"/>
                    </div>

                    <div class="mb-3">
                        <label>Discount Percent</label>
                        <input class="bg-gray-100" v-model="data.percent" placeholder="Discount Percent (Number only)">
                        <span v-text="errors.get('percent')" class="text-sm text-red-600"/>
                    </div>

                    <div class="mt-8 text-right">
                        <button @click="cancel()" class="button button-danger">Cancel</button>
                        <button v-if="data.id" @click="destroy(data.id)"
                                class="button bg-red-600 text-white">
                            Delete override
                        </button>
                        <button @click="save(data.id)" class="button bg-gray-700 text-white w-32">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
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
            discounts: {}
        },
        data() {
            return {
                customer_discounts: {},
                customer_discount_modal: false,
                data: {},
                editing: false,
                errors: new Errors(),
            }
        },
        methods: {
            edit: function (id, customer_code, discount, key) {
                this.editing = true;

                this.data = {
                    id: id,
                    customer_code: customer_code,
                    percent: discount,
                    key: key,
                };

                this.customer_discount_modal = true;
            },
            save: function (id = null) {
                this.errors = new Errors();

                if (id) {
                    this.data.id = id;
                }

                axios.post('/cms/discounts/customer', this.data).then(response => {
                    if (this.data.id) {
                        return window.location.reload();
                    } else {
                        this.customer_discounts.push(response.data);
                    }

                    this.cancel();
                }).catch(error => {
                    if (error.response) {
                        return this.errors.record(error.response.data.errors);
                    }
                });
            },
            cancel: function () {
                this.editing = false;
                this.data = {};
                this.customer_discount_modal = false;
            },
            destroy: function (id) {
                axios.delete('/cms/discounts/customer/' + id).then(response => {
                    return window.location.reload();
                }).catch(error => {
                    Vue.swal('Error', 'Unable to delete customer discount override', 'error');
                });
            }
        },
        mounted() {
            this.customer_discounts = this.discounts;
        }
    }
</script>
