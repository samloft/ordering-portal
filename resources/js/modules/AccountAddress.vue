<template>
    <div>
        <div v-for="address in addresses.data">
            <div class="rounded-lg shadow p-4 mb-3" :class="address.default ? 'bg-primary text-white' : 'bg-white'">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="font-medium">{{ address.company_name }}</div>
                        <div>{{ address.address_line_2 }}</div>
                        <div>{{ address.address_line_3 }}</div>
                        <div>{{ address.address_line_4 }}</div>
                        <div>{{ address.address_line_5 }}</div>
                        <div>{{ address.postcode }}</div>
                    </div>
                    <div class="text-right w-1/4">

                        <a v-if="checkout" :href="'/account/addresses/select/' + address.id"
                           class="btn-link">
                            <button class="button button-primary button-block mb-1">Select Address</button>
                        </a>

                        <div v-else>

                            <h4 v-if="address.default" class="text-white text-center text-1xl">Default Address</h4>

                            <form v-else method="post" action="/account/addresses/default" class="mb-1">
                                <button class="button button-inverse button-block" name="id" :value="address.id">
                                    Set As Default
                                </button>
                            </form>

                            <a :href="'/account/addresses/' + address.id + '/edit'">
                                <button class="button button-primary button-block mb-1">Edit Address</button>
                            </a>

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
                    type: "warning",
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
