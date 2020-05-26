<template>
    <div>
        <div v-for="address in addresses.data">
            <div class="rounded-lg shadow p-4 mb-3 bg-white">
                <div class="md:flex justify-between items-center">
                    <div class="mb-2 md:mb-0">
                        <div class="font-medium">{{ address.company_name }}</div>
                        <div>{{ address.address_line_2 }}</div>
                        <div>{{ address.address_line_3 }}</div>
                        <div>{{ address.address_line_4 }}</div>
                        <div>{{ address.address_line_5 }}</div>
                        <div>{{ address.postcode }}</div>
                    </div>
                    <div class="text-right md:w-1/4">

                        <a v-if="checkout" :href="'/account/addresses/select/' + address.id"
                           class="btn-link">
                            <button class="button button-primary button-block mb-1">Select Address</button>
                        </a>

                        <div v-else>

                            <div class="flex md:flex-col">
                                <div class="md:w-full w-1/2 ml-1 md:ml-0">
                                    <a :href="'/account/addresses/' + address.id + '/edit'">
                                        <button class="button button-primary button-block mb-1">Edit Address</button>
                                    </a>
                                </div>
                            </div>

                            <button id="delete-address"
                                    class="button button-danger button-block"
                                    :value="address.id"
                                    @click="removeAddress(address.id)"
                            >
                                Remove Address
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                image: null
            }
        },
        props: {
            addresses: {},
            checkout: false
        },
        methods: {
            removeAddress: function (id) {
                Vue.swal({
                    title: "Delete Address?",
                    text: "Are you sure? This cannot be un-done.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#EAB532',
                }).then((response) => {
                    if (response.value) {
                        location.href = '/account/addresses/' + id + '/delete';
                    }
                });
            }
        }
    }
</script>
