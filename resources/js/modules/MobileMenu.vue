<template>
    <div>
        <div @click="toggle()">
            <slot name="trigger"></slot>
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
