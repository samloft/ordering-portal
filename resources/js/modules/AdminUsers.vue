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
                    type: 'warning',
                    showCancelButton: true,
                }).then(response => {
                    if (response.value) {
                        return axios.delete('/cms/admin-users/' + id).then(function (response) {
                            if (response.data.deleted) {
                                return Vue.swal({
                                    title: "Deleted",
                                    text: "Admin user has been successfully deleted",
                                    type: "success"
                                }).then(response => {
                                    if (response.value) {
                                        return window.location.reload();
                                    }
                                });
                            } else {
                                Vue.swal('Error', 'Unable to delete user', 'error');
                            }
                        });
                    }
                }).catch(error => {
                    Vue.swal('Error', 'Unable to delete admin user', 'error');
                });
            },
            storeUser: function (id) {
                if (id) {
                    return axios.patch('/cms/admin-users/' + id, this.userData).then(response => {
                        return Vue.swal('Success', 'User has been updated', 'success');
                    }).catch(error => {
                        return Vue.swal('Error', 'Unable to update user, please try again', 'error');
                    });
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
