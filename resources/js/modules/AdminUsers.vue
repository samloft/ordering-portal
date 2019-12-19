<template>
    <div>
        <div @click="showModal()">
            <slot name="trigger"/>
        </div>

        <Transition name="fade">
            <div
                v-if="modal"
                class="fixed inset-0 w-full h-screen flex items-center justify-center bg-smoke-dark z-50">
                <div class="relative w-full max-w-2xl bg-white shadow-lg rounded-lg p-8 text-left">
                    <div class="mb-3">
                        <label>Name</label>
                        <input class="bg-gray-100" v-model="userData.name" placeholder="Name">
                    </div>

                    <div class="mb-3">
                        <label>Email Address</label>
                        <input class="bg-gray-100" v-model="userData.email" placeholder="Email Address">
                    </div>

                    <div class="mt-8 text-right">
                        <button @click="reload()" class="button button-danger">Exit</button>
                        <button v-if="userData.id" @click="deleteUser(userData.id)"
                                class="button bg-red-600 text-white">
                            Delete User
                        </button>
                        <button @click="storeUser(userData.id)" class="button bg-gray-700 text-white w-32">
                            {{ this.userData.id ? 'Edit' : 'Create' }}
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
                userData: {
                    id: null,
                    name: '',
                    email: '',
                },
            }
        },
        methods: {
            showModal: function () {
                if (this.user) {
                    this.userData = this.user;
                }

                this.modal = true;
            },
            deleteUser: function (id) {

            },
            storeUser: function (id) {
                if (id) {
                    return false;
                }

                return axios.post('/cms/admin-users', this.userData).then(response => {
                    this.userData = response.data;

                    return Vue.swal('Success', 'New CMS admin has been created', 'success');
                }).catch(error => {
                    return Vue.swal('Error', error.response.data.errors[Object.keys(error.response.data.errors)[0]][0], 'error');
                });
            },
            reload: function () {
                window.location.reload();
            }
        }
    }
</script>
