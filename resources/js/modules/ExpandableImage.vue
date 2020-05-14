<template>
    <div
        class="expandable-image"
        :class="{expanded: expanded}"
        @click="expanded = true">

        <i class="close-button">

            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="#666666"
                      d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
            </svg>

        </i>

        <div :class="expanded ? 'img-expanded' : ''" class="md:flex md:justfiy-center">
            <img v-bind="$attrs" :class="expanded ? 'img-expanded' : ''" class="max-w-16 max-h-16 md:max-w-32 md:max-h-32 mx-auto"/>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                expanded: false,
                closeButtonRef: null
            }
        },

        props: ['title', 'description'],

        methods: {
            closeImage(event) {
                this.expanded = false;
                event.stopPropagation()
            },
            freezeVp(e) {
                e.preventDefault()
            },
            closeIfClickedOutside(event) {
                if (!event.target.closest('img')) {
                    this.expanded = false;
                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            }
        },

        watch: {
            expanded(status) {
                this.$nextTick(() => {
                    if (status) {
                        this.cloned = this.$el.cloneNode(true);
                        this.closeButtonRef = this.cloned.querySelector('.close-button');
                        this.closeButtonRef.addEventListener('click', this.closeImage);
                        document.body.appendChild(this.cloned);
                        document.body.style.overflow = 'hidden';
                        this.cloned.addEventListener('touchmove', this.freezeVp, false);
                        document.addEventListener('click', this.closeIfClickedOutside);
                        setTimeout(() => {
                            this.cloned.style.opacity = 1;
                        }, 0)
                    } else {
                        this.cloned.style.opacity = 0;
                        this.cloned.removeEventListener('touchmove', this.freezeVp, false);
                        setTimeout(() => {
                            this.closeButtonRef.removeEventListener('click', this.closeImage);
                            this.cloned.remove();
                            this.cloned = null;
                            this.closeButtonRef = null;
                            document.body.style.overflow = 'auto'
                        }, 250)
                    }
                })
            }
        }
    }
</script>

<style>
    .img-list {
        max-width: 8rem;
        max-height: 8rem;
    }

    .img-list > img {
        margin: 0 auto;
        max-width: 8rem;
        max-height: 8rem;
    }

    .img-expanded {
        margin: 0 auto;
    }

    .img-expanded > img {
        max-height: 800px;
    }

    .expandable-image {
        transition: 0.50s opacity;
        cursor: zoom-in;
        min-width: 8rem;
    }

    .expandable-image.expanded {
        position: fixed;
        z-index: 999999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: black;
        display: flex;
        align-items: center;
        opacity: 0;
        padding-bottom: 0 !important;
        cursor: default;
    }

    .expandable-image.expanded > img {
        width: auto;
        max-height: 70%;
        margin: 0 auto;
    }

    .expandable-image.expanded > .close-button {
        display: block;
    }

    .expandable-image .close-button {
        position: fixed;
        top: 10px;
        right: 10px;
        display: none;
        cursor: pointer;
    }

    .expandable-image svg {
        filter: drop-shadow(1px 1px 1px rgba(0, 0, 0, 0.5));
    }

    .expandable-image svg path {
        fill: #fff;
    }

</style>
