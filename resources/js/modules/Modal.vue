<template>
    <fade-transition>
        <div
            class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center z-30">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div
                class="flex-grow bg-white rounded-lg px-4 pt-5 pb-4 shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                <h3 v-if="title" class="text-lg leading-6 font-medium text-gray-900 mb-3" v-text="title"/>

                <slot></slot>
            </div>
        </div>
    </fade-transition>
</template>

<script>
    export default {
        props: {
            title: null,
        },
    }
</script>
