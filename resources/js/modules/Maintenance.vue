<template>
    <div class="text-right">
        <button @click="maintenance()" class="button text-white" :class="customClass" v-text="message"/>
    </div>
</template>

<script>
    export default {
        props: {
            enabled: false,
        },
        data() {
            return {
                customClass: 'bg-gray-800',
                message: 'Enable site maintenance',
            }
        },
        methods: {
            maintenance: async function () {
                if (this.enabled) {
                    return axios.patch('/cms/site-settings/maintenance', {
                        enabled: false,
                        message: '',
                    }).then(function() {
                        return window.location.reload();
                    }).catch(function () {
                        return Vue.swal({
                            title: 'Error',
                            text: 'Unable to disable maintenance mode',
                            icon: 'error',
                            confirmButtonColor: '#E02424',
                        });
                    });
                }

                let maintenanceMessage = null,
                    submitted = false;

                const { value: message } = await Vue.swal({
                    title: 'Enter a custom message (optional)',
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    customClass: {
                        confirmButton: 'bg-gray-800 text-white',
                    },
                    inputValidator: (message) => {
                        submitted = true;
                        maintenanceMessage = message;
                    }
                });

                if (submitted) {
                    return axios.patch('/cms/site-settings/maintenance', {
                        enabled: true,
                        message: message
                    }).then(function() {
                        return window.location.reload();
                    }).catch(function () {
                        return Vue.swal({
                            title: 'Error',
                            text: 'Unable to enable maintenance mode',
                            icon: 'error',
                            confirmButtonColor: '#E02424',
                        });
                    });
                }
            }
        },
        mounted() {
            this.customClass = this.enabled ? 'bg-red-600' : 'bg-gray-800';
            this.message = this.enabled ? 'Disable site maintenance' : this.message;
        }
    }
</script>
