<template>
    <div>
        <div @click="showModal()">
            <slot name="trigger"/>
        </div>

        <modal v-if="modal">
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
        </modal>
    </div>
</template>

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
                Vue.swal({
                    title: 'Delete Admin User?',
                    text: 'Are you sure? This cannot be un-done.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EAB532',
                }).then(response => {
                    if (response.value) {
                        return axios.delete('/cms/admin-users/' + id).then(function (response) {
                            if (response.data.deleted) {
                                return Vue.swal({
                                    title: "Deleted",
                                    text: "Admin user has been successfully deleted",
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'bg-gray-800 text-white'
                                    }
                                }).then(response => {
                                    if (response.value) {
                                        return window.location.reload();
                                    }
                                });
                            } else {
                                return Vue.swal({
                                    title: 'Error',
                                    text: 'Unable to delete user',
                                    icon: 'error',
                                    confirmButtonColor: '#E02424',
                                });
                            }
                        });
                    }
                }).catch(error => {
                    return Vue.swal({
                        title: 'Error',
                        text: 'Unable to delete admin user',
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            },
            storeUser: function (id) {
                if (id) {
                    return axios.patch('/cms/admin-users/' + id, this.userData).then(response => {
                        return Vue.swal({
                            title: "Success",
                            text: "User has been updated",
                            icon: 'success',
                            customClass: {
                                confirmButton: 'bg-gray-800 text-white'
                            }
                        });
                    }).catch(error => {
                        Vue.swal({
                            title: 'Error',
                            text: 'Unable to update user, please try again',
                            icon: 'error',
                            confirmButtonColor: '#E02424',
                        });
                    });
                }

                return axios.post('/cms/admin-users', this.userData).then(response => {
                    this.userData = response.data;

                    return Vue.swal({
                        title: "Deleted",
                        text: "New CMS admin has been created",
                        icon: 'success',
                        customClass: {
                            confirmButton: 'bg-gray-800 text-white'
                        }
                    });
                }).catch(error => {
                    return Vue.swal({
                        title: 'Error',
                        text: error.response.data.errors[Object.keys(error.response.data.errors)[0]][0],
                        icon: 'error',
                        confirmButtonColor: '#E02424',
                    });
                });
            },
            reload: function () {
                window.location.reload();
            }
        }
    }
</script>
