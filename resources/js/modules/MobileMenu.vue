<template>
    <div>
        <div @click="toggle()">
            <slot name="trigger" :isOpen="isOpen">
                <div class="md:hidden">
                    <svg v-if="isOpen" width="32" height="32" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg" class="z-50 relative">
                        <path d="M6 18L18 6M6 6L18 18" stroke="#FFFFFF" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <svg v-else class="fill-current text-white h-8 w-8" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20">
                        <path
                            d="M16.4 9H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1h12.8c.552 0 .6-.447.6-1 0-.553-.048-1-.6-1zm0 4H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1h12.8c.552 0 .6-.447.6-1 0-.553-.048-1-.6-1zM3.6 7h12.8c.552 0 .6-.447.6-1 0-.553-.048-1-.6-1H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1z"></path>
                    </svg>
                </div>
            </slot>
        </div>

        <slot name="content" :isOpen="isOpen"></slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isOpen: false,
            }
        },
        methods: {
            toggle: function () {
                return this.isOpen = !this.isOpen;
            }
        }
    }
</script>
