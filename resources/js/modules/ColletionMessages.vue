<template>
    <div>
        <div class="mb-3 flex justify-between items-center">
            <div class="text-sm text-red-600">* Dont forget to click Save once you have finished.</div>
            <button @click="openModal()" type="button"
                    class="button bg-gray-700 text-white text-xs w-20">Add
            </button>
        </div>

        <div class="mb-3">
            <table v-if="data.times" class="w-full text-md bg-white shadow-md rounded mb-4">
                <tbody>
                <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
                    <th class="font-semibold p-2 px-5">Start</th>
                    <th class="font-semibold p-2 px-5">End</th>
                    <th class="font-semibold p-2 px-5">Message</th>
                    <th class="font-semibold p-2 px-5">Identifier</th>
                    <th></th>
                </tr>
                <tr class="border-b" v-for="(time, index) in data.times" :index="index">
                    <td class="p-1 px-5">{{ time.start }}</td>
                    <td class="p-1 px-5">{{ time.end }}</td>
                    <td class="p-1 px-5 text-xs leading-3">{{ time.message }}</td>
                    <td class="p-1 px-5 text-xs leading-3">{{ time.identifier }}</td>
                    <td class="p-1 px-5 flex justify-end">
                        <button @click="editTime(time)" type="button"
                                class="rounded bg-gray-700 py-1 px-3 mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"
                                 class="text-white fill-current">
                                <path
                                    d="M9 4.58V4c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v.58a8 8 0 0 1 1.92 1.11l.5-.29a2 2 0 0 1 2.74.73l1 1.74a2 2 0 0 1-.73 2.73l-.5.29a8.06 8.06 0 0 1 0 2.22l.5.3a2 2 0 0 1 .73 2.72l-1 1.74a2 2 0 0 1-2.73.73l-.5-.3A8 8 0 0 1 15 19.43V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.58a8 8 0 0 1-1.92-1.11l-.5.29a2 2 0 0 1-2.74-.73l-1-1.74a2 2 0 0 1 .73-2.73l.5-.29a8.06 8.06 0 0 1 0-2.22l-.5-.3a2 2 0 0 1-.73-2.72l1-1.74a2 2 0 0 1 2.73-.73l.5.3A8 8 0 0 1 9 4.57zM7.88 7.64l-.54.51-1.77-1.02-1 1.74 1.76 1.01-.17.73a6.02 6.02 0 0 0 0 2.78l.17.73-1.76 1.01 1 1.74 1.77-1.02.54.51a6 6 0 0 0 2.4 1.4l.72.2V20h2v-2.04l.71-.2a6 6 0 0 0 2.41-1.4l.54-.51 1.77 1.02 1-1.74-1.76-1.01.17-.73a6.02 6.02 0 0 0 0-2.78l-.17-.73 1.76-1.01-1-1.74-1.77 1.02-.54-.51a6 6 0 0 0-2.4-1.4l-.72-.2V4h-2v2.04l-.71.2a6 6 0 0 0-2.41 1.4zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                            </svg>
                        </button>
                        <button @click="removeTime(index)" type="button" class="rounded bg-red-600 py-1 px-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"
                                 class="text-white fill-current">
                                <path
                                    d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

            <div v-else class="text-center font-semibold underline">
                No collection times added.
            </div>
        </div>

        <div class="mb-3">
            <label for="default-message">Default Message</label>
            <span class="text-sm text-gray-600">Anything added here will ignore any timed messages, so dont use this if you want to use timed.</span>
            <input id="default-message" class="bg-gray-100" v-model="data.default">
        </div>

        <div class="text-right">
            <button @click="store()" type="submit" class="button bg-gray-800 text-white">Save</button>
        </div>

        <modal v-if="modal">
            <div class="mb-3">
                <label for="start-time">Start Time</label>
                <input id="start-time" class="bg-gray-100" v-model="time.start" placeholder="00:00:00">
                <span v-text="errors.get('start_time')" class="text-sm text-red-600"/>
            </div>

            <div class="mb-3">
                <label for="end-time">End Time</label>
                <input id="end-time" class="bg-gray-100" v-model="time.end" placeholder="11:00:00">
                <span v-text="errors.get('start_time')" class="text-sm text-red-600"/>
            </div>

            <div class="mb-3">
                <label for="message">Message</label>
                <input id="message" class="bg-gray-100" v-model="time.message" placeholder="Message that the customer sees" required>
                <span v-text="errors.get('message')" class="text-sm text-red-600"/>
            </div>

            <div class="mb-3">
                <label for="identifier">Identifier</label>
                <input id="identifier" class="bg-gray-100" v-model="time.identifier" placeholder="Identifier for DX line" required>
                <span v-text="errors.get('identifier')" class="text-sm text-red-600"/>
            </div>

            <div v-if="!updating" class="mt-8 text-right">
                <button @click="modal = false" class="button button-danger">Exit</button>
                <button @click="addTime()" class="button bg-gray-700 text-white w-32">Add</button>
            </div>

            <div v-else class="mt-8 text-right">
                <button @click="modal = false" class="button bg-gray-700 text-white w-32">Close</button>
            </div>
        </modal>
    </div>
</template>

<script>
    class Errors {
        constructor() {
            this.errors = {};
        }

        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        record(errors) {
            this.errors = errors;
        }
    }

    export default {
        props: {
            collection_messages: {},
        },
        data() {
            return {
                modal: false,
                data: {},
                errors: new Errors(),
                time: {},
                updatating: false,
            }
        },
        methods: {
            openModal() {
                this.updating = false;
                this.time = {};
                this.modal = true;
            },
            addTime() {
                this.data.times.push(this.time);

                this.modal = false;
            },
            removeTime(index) {
                this.data.times.splice(index, 1);
            },
            editTime(time) {
                this.updating = true;
                this.time = time;
                this.modal = true;
            },
            store() {
                axios.post('/cms/delivery-methods/collection-messages', this.data).then(function() {
                    return Vue.swal('Success', 'Collection time messages have been saved');
                }).catch(function() {
                    return Vue.swal('Error', 'Unable to update collection time messages, please try again');
                });
            }
        },
        mounted: function () {
            this.data = this.collection_messages;
        }
    }
</script>
