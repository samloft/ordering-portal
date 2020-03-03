<template>
    <div>
        <button @click="submit()" class="button button-primary" v-text="buttonText" :disabled="submitted"></button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                submitted: false,
                buttonText: '',
            }
        },
        props: {
            beforeText: '',
            afterText: '',
        },
        methods: {
            submit() {
                this.submitted = true;
                this.buttonText = this.afterText;
            }
        },
        mounted() {
            this.buttonText = this.beforeText;
        }
    }
</script>
