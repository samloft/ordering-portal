<template>
    <div class="dropdown .md:block .md:flex .md:items-center">
        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="isOpen"
             @click="isOpen = !isOpen">
            <slot name="trigger"></slot>
        </div>

        <div v-show="isOpen" class="dropdown-menu absolute bg-gray-100 py-2 rounded shadow-lg mt-4 text-left w-full"
             :class="align === 'left' ? 'left-0' : 'right-0'">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            align: {default: 'left'}
        },
        data() {
            return {isOpen: false}
        },
        watch: {
            isOpen(isOpen) {
                if (isOpen) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            }
        },
        methods: {
            closeIfClickedOutside(event) {
                if (!event.target.closest('.dropdown')) {
                    this.isOpen = false;
                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            }
        }
    }
</script>
