<template>
    <section>
        <div class="relative">
            <flat-pickr
                v-model="date"
                :config="config"
                :name="input_name">
            </flat-pickr>
            <div v-show="date_populated">
                <i class="fa fa-times cursor-pointer absolute inset-y-0 right-0 flex items-center px-3 text-gray-700 pt-3" title="clear" data-clear>
                    <span aria-hidden="true" class="sr-only">Clear</span>
                </i>
            </div>
        </div>
    </section>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/themes/airbnb.css';

    export default {
        props: {
            input_name: String,
            old_value: String,
        },
        name: 'date-picker',
        data() {
            return {
                date: this.old_value,
                config: {
                    wrap: true,
                    altFormat: 'd-m-Y',
                    altInput: true,
                    dateFormat: 'd-m-Y',
                },
                date_populated: !!this.old_value
            }
        },
        updated() {
            this.date_populated = !!this.date
        },
        components: {
            flatPickr
        },
    }
</script>
