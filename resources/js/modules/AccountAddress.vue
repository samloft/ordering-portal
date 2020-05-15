<template>
    <div>
        <div v-for="address in addresses.data">
            <div class="rounded-lg shadow p-4 mb-3" :class="address.default ? 'bg-primary text-white' : 'bg-white'">
                <div class="md:flex justify-between items-center">
                    <div class="mb-2 md:mb-0">
                        <h4 v-if="address.default" class="md:hidden mb-2 text-white text-center text-1xl">Default
                            Address</h4>

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

                            <h4 v-if="address.default" class="hidden md:show text-white text-center text-1xl">Default
                                Address</h4>

                            <div class="flex md:flex-col">
                                <div v-if="!address.default" class="w-1/2 md:w-full" :class="!address.default ? 'mr-1 md:mr-0' : ''">
                                    <form method="post" action="/account/addresses/default"
                                          class="mb-1">
                                        <button class="button button-inverse button-block" name="id"
                                                :value="address.id">
                                            Set As Default
                                        </button>
                                    </form>
                                </div>

                                <div :class="!address.default ? 'w-1/2 ml-1 md:ml-0' : 'w-full'" class="md:w-full">
                                    <a :href="'/account/addresses/' + address.id + '/edit'">
                                        <button class="button button-primary button-block mb-1">Edit Address</button>
                                    </a>
                                </div>
                            </div>

                            <button v-if="!address.default" id="delete-address"
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
                }).then((response) => {
                    if (response.value) {
                        location.href = '/account/addresses/' + id + '/delete';
                    }
                });
            }
        }
    }
</script>
