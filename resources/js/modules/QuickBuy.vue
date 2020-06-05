<template>
    <div class="quickbuy">
        <div class="relative">
            <input type="text" ref="product" :placeholder="placeHolderText" v-model="keywordSearch" class="mb-1"
                   @keyup="onKeyUp(keywordSearch)" @keyup.enter="submit()"/>

            <div class="absolute -mt-2 w-full">
                <ul class="rounded-b-lg w-full border-l border-r border-b" v-show="resultItems.length > 0">
                    <li class="cursor-pointer odd:bg-gray-100 even:bg-white hover:bg-gray-200 p-2" v-for="item in resultItems"
                        @click="onSelected(item.code)">
                        {{ item.code }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex">
            <div class="flex items-center">
                <span class="mr-2 text-gray-600">Qty:</span>
                <input class="w-24 mr-2" value="1" v-model="quantity" @keyup.enter="submit()" autocomplete="off" @focus="resultItems = []">
            </div>
            <button class="button button-primary flex-grow flex justify-center" @click="submit()" type="submit" :disabled="addingProduct">
                {{ buttonText }} <svg v-if="addingProduct" xmlns="http://www.w3.org/2000/svg"
                                      width="15px" height="15px" viewBox="0 0 40 40" enable-background="new 0 0 40 40"
                                      xml:space="preserve" class="ml-3">
                              <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                                  s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                                  c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
                <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                                  C22.32,8.481,24.301,9.057,26.013,10.047z">
                                <animateTransform attributeType="xml"
                                                  attributeName="transform"
                                                  type="rotate"
                                                  from="0 20 20"
                                                  to="360 20 20"
                                                  dur="0.5s"
                                                  repeatCount="indefinite"/>
                              </path>
           </svg>
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
                buttonText: 'Add to basket',
                addingProduct: false,
            }
        },
        watch: {
            resultItems(resultItems) {
                if (resultItems.length > 0) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            }
        },
        methods: {
            submit: function () {
                let self = this;

                this.buttonText = 'Adding...';
                this.addingProduct = true;

                App.addProductToBasket(this.keywordSearch, this.quantity).then(result => {
                    if (result) {
                        self.keywordSearch = '';
                        self.quantity = 1;
                        self.$refs.product.focus();
                    }

                    self.buttonText = 'Add to basket';
                    self.addingProduct = false;
                    self.resultItems = [];
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
            closeIfClickedOutside(event) {
                if (!event.target.closest('.quickbuy')) {
                    this.resultItems = [];
                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            }
        }
    }
</script>
