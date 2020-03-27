<template>
    <div>
        <fade-transition>
            <div v-show="open"
                 class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Small order charge
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm leading-5 text-gray-500 mb-5">
                                        You are currently under our small order threshold of <span
                                        class="font-semibold">{{ currency + threshold }}</span>.
                                    </p>

                                    <p class="text-sm leading-5 text-gray-500 mb-5">
                                        If you continue you will be charged a <span
                                        class="font-semibold">{{ currency + charge }}</span>

                                        {{ message }}
                                    </p>

                                    <p class="text-sm leading-5 text-gray-500">
                                        You only need to add
                                        <span
                                            class="font-semibold">{{ currency + (threshold - goodsTotal) }}</span>
                                        worth of products to avoid this charge.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
      <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
        <button type="button" @click="open = false"
                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
          Continue checkout
        </button>
      </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
        <a href="/basket">
                        <button type="button"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
          Add more items to basket
        </button>
        </a>
      </span>
                    </div>
                </div>
            </div>
        </fade-transition>
    </div>
</template>

<script>
    export default {
        props: {
            threshold: 0,
            charge: 0,
            goodsTotal: 0,
            message: '',
            currency: '',
            validationErrors: false,
        },
        data() {
            return {
                open: false,
            }
        },
        mounted() {
            if (this.goodsTotal < this.threshold && !this.validationErrors) {
                this.open = true;
            }
        }
    }
</script>
