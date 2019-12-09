<template>
    <div>
        <div class="relative">
            <input type="text" :placeholder="placeHolderText" v-model="keywordSearch" class="mb-1"
                   @keyup="onKeyUp(keywordSearch)"/>

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
                placeHolderText: '',
            }
        },
        methods: {
            submit: function() {
                App.addProductToBasket(this.keywordSearch, this.quantity).then(result => {
                    if (result) {
                        this.keywordSearch = '';
                        this.quantity = 1;
                    }
                });
            },
            onSelected(name) {
                this.resultItems = [];
                this.keywordSearch = name;
            },
            onKeyUp(keywordEntered) {
                this.resultItems = [];

                if (keywordEntered.length > 2) {
                    axios.get('/products/autocomplete/' + keywordEntered)
                        .then(response => {
                            var newData = [];

                            response.data.forEach(function (item) {
                                if (item.code.toLowerCase().indexOf(keywordEntered.toLowerCase()) >= 0) {
                                    newData.push(item);
                                }
                            });

                            this.resultItems = newData;
                        })
                        .catch(e => {
                            this.resultItems = [];
                        })
                } else {
                    this.resultItems = [];
                }
            },
        }
    }
</script>
