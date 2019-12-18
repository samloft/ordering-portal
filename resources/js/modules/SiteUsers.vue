<template>
    <div>
        <div @click="showModal()">
            <slot name="trigger"/>
        </div>

        <Transition name="fade">
            <div
                v-if="modal"
                class="fixed inset-0 w-full h-screen flex items-center justify-center bg-smoke-dark z-50"
            >
                <div class="relative w-full max-w-2xl bg-white shadow-lg rounded-lg p-8 text-left">
                    <div class="mb-3">
                        <label>Name</label>
                        <input class="bg-gray-100" v-model="userData.name" placeholder="Name">
                    </div>

                    <div class="mb-3">
                        <label>Email Address</label>
                        <input class="bg-gray-100" v-model="userData.email" placeholder="Email Address">
                    </div>

                    <div class="mb-3">
                        <div class="flex">
                            <div class="w-full relative mr-1">
                                <label>Account Type</label>
                                <select v-model="userData.admin"
                                        class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                                        autocomplete="off">
                                    <option value="0">Normal User</option>
                                    <option value="1">Site Administrator</option>
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

                            <div class="w-full relative ml-1">
                                <label>Browse Only</label>
                                <select v-model="userData.can_order"
                                        class="p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                                        autocomplete="off">
                                    <option value="1">No</option>
                                    <option value="0">Yes</option>
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
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Customer Code</label>
                        <input class="bg-gray-100" v-model="userData.customer_code" v-uppercase placeholder="Customer Code">
                    </div>

                    <div v-if="userData.id && (parseInt(userData.admin) !== 1)" class="mb-3">
                        <label>Additional Customers</label>
                        <table class="w-full text-sm bg-white rounded border">
                            <tbody>
                            <tr class="text-left border-b bg-gray-300 uppercase text-xs tracking-widest">
                                <th class="font-semibold p-1">Code</th>
                                <th class="text-right p-1">
                                    <button @click="addAdditionalCustomer"
                                            class="rounded leading-none text-white bg-gray-700 p-1 text-xs hover:opacity-75">
                                        Add Customer
                                    </button>
                                </th>
                            </tr>
                            <tr v-for="(customer, index) in listAdditionalCustomers()"
                                class="border-b hover:bg-gray-100">
                                <td class="p-1">{{ customer.customer_code }}</td>
                                <td class="p-1 text-right">
                                    <button
                                        @click="deleteAdditionalCustomer(index, customer.customer_code, customer.id)"
                                        class="rounded leading-none border-2 border-red-600 text-red-600 bg-white p-1 text-xs hover:bg-red-600 hover:text-white">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div v-if="customers.length === 0" class="border text-center p-3">
                            No additional customers added
                        </div>
                    </div>

                    <div v-if="!userData.id && (parseInt(userData.admin) !== 1)" class="mb-3">
                        <label>Additional Customers</label>
                        <div class="border text-center p-3 text-gray-500 underline">You must save the user before you can add extra customers
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="flex">
                            <div class="mr-1">
                                <label>Telephone</label>
                                <input class="bg-gray-100" v-model="userData.telephone" placeholder="Telephone Number">
                            </div>

                            <div class="ml-1">
                                <label>Mobile</label>
                                <input class="bg-gray-100" v-model="userData.mobile" placeholder="Mobile Number">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-right">
                        <button @click="reload()" class="button button-danger">Exit</button>
                        <button v-if="userData.id" @click="deleteUser(userData.id)" class="button bg-red-600 text-white">Delete
                            User
                        </button>
                        <button v-if="userData.id" @click="passwordReset(userData.email)"
                                class="button bg-gray-500 text-white">Password
                            Reset
                        </button>
                        <button @click="storeUser(userData.id)" class="button bg-gray-700 text-white w-32">{{ buttonText
                            }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>


<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: all 0.4s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }
</style>

<script>
    export default {
        props: {
            user: null,
        },
        data() {
            return {
                modal: false,
                buttonText: 'Create',
                userData: {
                    id: null,
                    name: '',
                    email: '',
                    telephone: '',
                    mobile: '',
                    customer_code: '',
                    admin: 0,
                    can_order: 1,
                },
                customers: []
            }
        },
        methods: {
            showModal: function () {
                if (this.user) {
                    this.buttonText = 'Edit';
                    this.userData = this.user;
                }

                this.modal = true;
            },
            storeUser: function (id = null) {
                if (id) {
                    return axios.patch('/cms/site-users/' + id, this.userData).then(function (response) {
                        return Vue.swal('Success', 'User has been updated', 'success');
                    }).catch(function (response) {
                        return Vue.swal('Error', 'Unable to update user, please try again', 'error');
                    });
                }

                return axios.post('/cms/site-users', this.userData).then(response => {
                    this.userData = response.data;

                    return Vue.swal('Success', 'New user has been created', 'success');
                }).catch(error => {
                    return Vue.swal('Error', error.response.data.errors[Object.keys(error.response.data.errors)[0]][0], 'error');
                });
            },
            passwordReset: function (email) {
                console.log(email);
                axios.post('/cms/site-users/password-reset', {
                    email: email
                }).then(function (response) {
                    Vue.swal('Success', 'Password reset has been sent to ' + email, 'success');
                }).catch(function (response) {
                    Vue.swal('Error', 'Unable to send password reset, please try again', 'error');
                })
            },
            listAdditionalCustomers: function () {
                return this.customers;
            },
            addAdditionalCustomer: function () {
                Vue.swal({
                    title: 'Type in a customer code to add',
                    input: 'text',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to enter a customer code.'
                        }

                        var code = value.toUpperCase(),
                            self = this,
                            id = this.userData.id;

                        return axios.get('/cms/customer/validate?code=' + code).then(function (response) {
                            if (response.data.code) {
                                return axios.post('/cms/site-users/extra-customers', {
                                    id: id,
                                    code: response.data.code
                                }).then(function (response) {
                                    if (response.data.success) {
                                        self.customers.push({
                                            id: response.data.id,
                                            customer_code: code
                                        });
                                    } else {
                                        return response.data.errors.first;
                                    }
                                }).catch(function () {
                                    return 'Unable to add user, please make sure it does not already exist for this customer';
                                });
                            } else {
                                return 'Customer not valid, please try again';
                            }
                        });
                    }
                });
            },
            deleteAdditionalCustomer: function (index, code, id) {
                var self = this;

                Vue.swal({
                    title: 'Delete additional customer ' + code + ' ?',
                    text: 'Are you sure? This cannot be un-done.',
                    type: 'warning',
                    showCancelButton: true,
                }).then((response) => {
                    if (response.value) {
                        return axios.delete('/cms/site-users/extra-customers', {
                            data: {id: id}
                        }).then(function (response) {
                            if (response.data) {
                                self.customers.splice(self.customers.indexOf(index), 1);
                            } else {
                                Vue.swal('Error', 'Unable to delete user customer', 'error');
                            }
                        });
                    }
                });
            },
            deleteUser: function (id) {
                Vue.swal({
                    title: 'Delete User?',
                    text: 'Are you sure? This cannot be un-done.',
                    type: 'warning',
                    showCancelButton: true,
                }).then((response) => {
                    if (response.value) {
                        return axios.delete('/cms/site-users/' + id).then(function (response) {
                            if (response.data.deleted) {
                                return Vue.swal({
                                    title: "Deleted",
                                    text: "Site user has been successfully deleted",
                                    type: "success"
                                }).then(function(response) {
                                    if(response.value) {
                                        return window.location.reload();
                                    }
                                });
                            } else {
                                Vue.swal('Error', 'Unable to delete user', 'error');
                            }
                        });
                    }
                }).catch(function (response) {
                    Vue.swal('Error', 'Unable to delete user', 'error');
                });
            },
            reload: function () {
                window.location.reload();
            }
        },
        created() {
            this.customers = this.user ? this.user.customers : [];
        }
    }
</script>
