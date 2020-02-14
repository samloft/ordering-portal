<template>
    <div>
        <div class="text-right mb-5">
            <button @click="showModal()" class="button bg-gray-800 text-white">New contact</button>
        </div>

        <table class="w-full text-md bg-white shadow-md rounded mb-4">
            <tbody>
            <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
                <th class="font-semibold p-2 px-5">Display Name</th>
                <th class="font-semibold p-2 px-5">Email Address</th>
                <th></th>
            </tr>
            <tr class="border-b" v-for="contact in contacts">
                <td class="p-1 px-5">{{ contact.name }}</td>
                <td class="p-1 px-5"><span class="badge badge-info">{{ contact.email }}</span></td>
                <td class="p-1 px-5 flex justify-end">
                    <button @click="showModal(contact)" type="button"
                            class="button bg-gray-700 text-white text-xs w-20">
                        Edit
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <Transition name="fade">
            <div v-if="modal"
                 class="fixed inset-0 w-full h-screen flex items-center justify-center bg-smoke-dark z-50">
                <div class="relative w-full max-w-2xl bg-white shadow-lg rounded-lg p-8 text-left">
                    <div class="mb-3">
                        <label for="delivery_code">Display Name</label>
                        <input id="delivery_code" class="bg-gray-100" v-model="data.name"
                               placeholder="Name to display on the dropdown">
                        <span v-text="errors.get('name')" class="block text-sm text-red-600"/>
                    </div>

                    <div class="mb-3">
                        <label for="delivery_title">Email</label>
                        <input id="delivery_title" class="bg-gray-100" v-model="data.email"
                               placeholder="Email Address">
                        <span v-text="errors.get('email')" class="block text-sm text-red-600"/>
                    </div>

                    <div class="text-right">
                        <button @click="closeModal()" class="button button-danger">Exit</button>
                        <button v-show="editing" @click="destroy(data.id)" class="button bg-red-600 text-white">Delete</button>
                        <button @click="save(data)" class="button bg-gray-700 text-white w-32" v-text="buttonText"/>
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
            contacts: {},
        },
        data() {
            return {
                modal: false,
                data: {},
                buttonText: 'Save',
                errors: new Errors(),
                editing: false,
                full_contacts: {},
            }
        },
        methods: {
            showModal(contact = {}) {
                this.data = contact;

                this.editing = !!Object.keys(contact).length > 0;
                this.buttonText = this.editing ? 'Update' : 'Save';

                this.modal = true;
            },
            closeModal() {
                this.modal = false;
            },
            save(contact = {}) {
                this.errors = new Errors();

                if (contact.id) {
                    return axios.patch('/cms/contacts/' + this.data.id, this.data).then(function (response) {
                        return Vue.swal({
                            title: 'Success',
                            text: 'Contact has been updated',
                            type: 'success',
                            showCancelButton: false,
                        }).then(response => {
                            return window.location.reload();
                        });
                    }).catch(error => {
                        if (error.response) {
                            return this.errors.record(error.response.data.errors);
                        }
                    });
                }

                return axios.post('/cms/contacts', this.data).then(function (response) {
                    return Vue.swal({
                        title: 'Success',
                        text: 'New contact has been created',
                        type: 'success',
                        showCancelButton: false,
                    }).then(response => {
                        return window.location.reload();
                    });
                }).catch(error => {
                    if (error.response) {
                        return this.errors.record(error.response.data.errors);
                    }
                });
            },
            destroy(id) {
                Vue.swal({
                    title: 'Delete Contact?',
                    text: 'Are you sure? This cannot be un-done.',
                    type: 'warning',
                    showCancelButton: true,
                }).then(response => {
                    if (response.value) {
                        return axios.delete('/cms/contacts/' + id).then(function (response) {
                            return Vue.swal({
                                title: "Deleted",
                                text: "Contact has been successfully deleted",
                                type: "success"
                            }).then(response => {
                                if (response.value) {
                                    return window.location.reload();
                                }
                            });
                        });
                    }
                }).catch(error => {
                    Vue.swal('Error', 'Unable to delete contact', 'error');
                });
            }
        },
    }
</script>
