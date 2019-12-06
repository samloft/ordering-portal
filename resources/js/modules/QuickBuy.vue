<template>
    <div>
        <div class="relative">
            <input type="text" :placeholder="placeHolderText" v-model="keywordSearch" class="mb-1"
                   @keyup="!autoCompleteProgress ? onKeyUp(keywordSearch) : ''"/>

            <div class="absolute -mt-2 w-full">
                <ul class="bg-gray-100 rounded-b-lg w-full border-l border-r border-b" v-show="resultItems.length > 0">
                    <li class="cursor-pointer hover:bg-gray-200 p-2" v-for="item in resultItems"
                        @click="onSelected(item.code)">
                        {{ item.code }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex">
            <div class="align-items-center">
                <span class="mr-2 text-gray-600">Qty:</span>
                <input class="w-24 mr-2" value="1" v-model="quantity" autocomplete="off">
            </div>
            <button class="button button-primary flex-grow" @click="submit()" type="submit">
                Add to basket
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                product: '',
                quantity: 1,
                keywordSearch: '',
                resultItems: [],
                autoCompleteProgress: '',
                placeHolderText: '',
            }
        },
        methods: {
            submit: function () {
                var self = this;

                axios.post('/basket/add-product', {
                    product: this.keywordSearch,
                    quantity: this.quantity
                })
                    .then(function (response) {
                        if (response.data.message) {
                            Vue.swal('Warning', response.data.message, 'warning');
                        }

                        self.addedToBasket(response.data);
                    })
                    .catch(function (error) {
                        if (error.response) {
                            Vue.swal('Error', error.response.data.message, 'error');
                        }
                    })
                    .finally(function () {
                        self.keywordSearch = '';
                    });
            },
            addedToBasket: function (payload) {
                Event.$emit('product-added', payload);
            },
            onSelected(name) {
                this.autoCompleteProgress = false;
                this.resultItems = [];
                this.keywordSearch = name;
            },
            onKeyUp(keywordEntered) {
                this.resultItems = [];
                this.autoCompleteProgress = false;

                if (keywordEntered.length > 2) {
                    this.autoCompleteProgress = true;

                    axios.get('/products/autocomplete/' + keywordEntered)
                        .then(response => {
                            var newData = [];

                            response.data.forEach(function (item) {
                                if (item.code.toLowerCase().indexOf(keywordEntered.toLowerCase()) >= 0) {
                                    newData.push(item);
                                }
                            });

                            this.resultItems = newData;
                            this.autoCompleteProgress = false;
                        })
                        .catch(e => {
                            this.autoCompleteProgress = false;
                            this.resultItems = [];
                        })
                } else {
                    this.autoCompleteProgress = false;
                    this.resultItems = [];
                }
            },
        }
    }
</script>
