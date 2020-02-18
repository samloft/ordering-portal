<template>
    <div>
        <div class="text-right mb-5">
            <button @click="showModal()" class="button bg-gray-800 text-white">New delivery method</button>
        </div>

        <table class="w-full text-md bg-white shadow-md rounded mb-4">
            <tbody>
            <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
                <th class="font-semibold p-2 px-5">Code</th>
                <th class="font-semibold p-2 px-5">Title</th>
                <th class="font-semibold p-2 px-5">Price under small order</th>
                <th class="font-semibold p-2 px-5">Price over small order</th>
                <th></th>
            </tr>
            <tr class="border-b" v-for="deliveryMethod in delivery_methods">
                <td class="p-1 px-5">{{ deliveryMethod.code }}</td>
                <td class="p-1 px-5">{{ deliveryMethod.title }}</td>
                <td class="p-1 px-5 text-right"><span class="badge badge-info">{{ deliveryMethod.price_low }}</span>
                </td>
                <td class="p-1 px-5 text-right"><span class="badge badge-info">{{ deliveryMethod.price }}</span></td>
                <td class="p-1 px-5 flex justify-end">
                    <button @click="showModal(deliveryMethod)" type="button"
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
                        <label for="delivery_code">Delivery Code</label>
                        <input id="delivery_code" class="bg-gray-100" v-model="data.code"
                               placeholder="Delivery Code E.G M1994">
                        <span v-text="errors.get('code')" class="block text-sm text-red-600"/>
                    </div>

                    <div class="mb-3">
                        <label for="delivery_title">Delivery Title</label>
                        <input id="delivery_title" class="bg-gray-100" v-model="data.title"
                               placeholder="Delivery title (What the user sees on checkout)">
                        <span v-text="errors.get('title')" class="block text-sm text-red-600"/>
                    </div>

                    <div class="mb-3">
                        <label for="delivery_identifier">Identifier</label>
                        <input id="delivery_identifier" class="bg-gray-100" v-model="data.identifier"
                               placeholder="Delivery identifier (What is displayed on the order)">
                        <span v-text="errors.get('identifier')" class="block text-sm text-red-600"/>
                        <small>The text that is displayed on the description for the order</small>
                    </div>

                    <div class="mb-3">
                        <label for="price">Price Below Small Order</label>
                        <input id="price" class="bg-gray-100" v-model="data.price"
                               placeholder="Price below small order">
                        <span v-text="errors.get('price')" class="block text-sm text-red-600"/>
                        <small>The price that will be payed if the order is <span class="font-semibold">BELOW</span> the
                            small order threshold E.G 25</small>
                    </div>

                    <div class="mb-3">
                        <label for="price_low">Price Over Small Order</label>
                        <input id="price_low" class="bg-gray-100" v-model="data.price_low"
                               placeholder="Price over small order">
                        <span v-text="errors.get('price_low')" class="block text-sm text-red-600"/>
                        <small>The price that will be payed if the order is <span class="font-semibold">OVER</span> the
                            small order threshold E.G 20</small>
                    </div>

                    <div class="text-right">
                        <button @click="closeModal()" class="button button-danger">Exit</button>
                        <button v-show="editing" @click="destroy(data.id)" class="button bg-red-600 text-white">Delete
                        </button>
                        <button @click="save()" class="button bg-gray-700 text-white w-32" v-text="buttonText"/>
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
            delivery_methods: {},
        },
        data() {
            return {
                modal: false,
                data: {},
                buttonText: 'Save',
                errors: new Errors(),
                editing: false,
            }
        },
        methods: {
            showModal(delivery_data = {}) {
                this.data = delivery_data;

                this.editing = !!Object.keys(delivery_data).length > 0;
                this.buttonText = Object.keys(delivery_data).length > 0 ? 'Update' : 'Save';

                this.modal = true;
            },
            closeModal() {
                this.modal = false;
            },
            save() {
                this.errors = new Errors();

                return axios.post('/cms/delivery-methods', this.data).then(function (response) {
                    return Vue.swal({
                        title: 'Success',
                        text: 'New delivery method has been created',
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
                    title: 'Delete Delivery Method?',
                    text: 'Are you sure? This cannot be un-done.',
                    type: 'warning',
                    showCancelButton: true,
                }).then(response => {
                    if (response.value) {
                        return axios.delete('/cms/delivery-methods/' + id).then(function (response) {
                            return Vue.swal({
                                title: "Deleted",
                                text: "Delivery method has been successfully deleted",
                                type: "success"
                            }).then(response => {
                                if (response.value) {
                                    return window.location.reload();
                                }
                            });
                        });
                    }
                }).catch(error => {
                    Vue.swal('Error', 'Unable to delete delivery method', 'error');
                });
            },
        }
    }
</script>
