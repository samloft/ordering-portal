<template>
    <div class="w-1/5 px-3">
        <a :href="'/products/' + (current.level_1 ? current.level_1 + '/' : '') + (current.level_2 ? current.level_2 + '/' : '') + category.key">
            <div class="bg-white relative text-center rounded-lg mb-6 shadow-md hover:shadow-lg">
                <div class="h-40">
                    <img v-if="productImageUrl"
                         class="h-32 mx-auto"
                         :alt="category.key"
                         :src="productImageUrl"
                    >

                    <div v-else class="flex items-center justify-center h-full">
                        <svg height="10" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg"
                             fill="rgba(113, 128, 150, 1.0)">
                            <circle cx="15" cy="15" r="15">
                                <animate attributeName="r" from="15" to="15"
                                         begin="0s" dur="0.8s"
                                         values="15;9;15" calcMode="linear"
                                         repeatCount="indefinite"/>
                                <animate attributeName="fill-opacity" from="1" to="1"
                                         begin="0s" dur="0.8s"
                                         values="1;.5;1" calcMode="linear"
                                         repeatCount="indefinite"/>
                            </circle>
                            <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                <animate attributeName="r" from="9" to="9"
                                         begin="0s" dur="0.8s"
                                         values="9;15;9" calcMode="linear"
                                         repeatCount="indefinite"/>
                                <animate attributeName="fill-opacity" from="0.5" to="0.5"
                                         begin="0s" dur="0.8s"
                                         values=".5;1;.5" calcMode="linear"
                                         repeatCount="indefinite"/>
                            </circle>
                            <circle cx="105" cy="15" r="15">
                                <animate attributeName="r" from="15" to="15"
                                         begin="0s" dur="0.8s"
                                         values="15;9;15" calcMode="linear"
                                         repeatCount="indefinite"/>
                                <animate attributeName="fill-opacity" from="1" to="1"
                                         begin="0s" dur="0.8s"
                                         values="1;.5;1" calcMode="linear"
                                         repeatCount="indefinite"/>
                            </circle>
                        </svg>

                    </div>

                </div>

                <div class="absolute inset-x-0 bottom-0 bg-gray-200 rounded-b-lg py-2 text-xs">
                    <span>{{ category.key }}</span>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                productImageUrl: null,
            }
        },
        props: {
            category: {},
            current: null,
        },
        methods: {
            imageUrl: async function (override, products) {
                console.log(override, products);

                if (override) {
                    return override;
                } else {
                    return axios.get('/category/image/' + products)
                        .then(response => {
                            return this.productImageUrl = response.data.image;
                        });
                }
            }
        },
        mounted() {
            this.imageUrl(this.category.override, this.category.product_list);
        }
    }
</script>
