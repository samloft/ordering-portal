<template>
    <div>
        <span @click="open = true" class="cursor-pointer">View</span>

        <modal v-if="open" class="text-left">
            <div class="mb-3">
                <h4>Before</h4>
                <pre class="p-3 bg-gray-300 rounded">{{ log.old ? JSON.stringify(log.old, null, 2).trim() : '' }}</pre>
            </div>

            <div class="mb-3">
                <h4>After</h4>
                <pre class="p-3 bg-gray-300 rounded">{{ JSON.stringify(log.attributes, null, 2).trim() }}</pre>
            </div>

            <div class="text-right">
                <button @click="open = false" type="button" class="button bg-gray-700 text-white text-xs w-20">
                    Close
                </button>
            </div>
        </modal>
    </div>
</template>

<script>
    export default {
        props: {
            log: {},
        },
        data() {
            return {
                open: false
            }
        }
    }
</script>
