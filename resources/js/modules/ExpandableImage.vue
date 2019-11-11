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

        <img v-bind="$attrs"/>
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

        methods: {
            closeImage(event) {
                this.expanded = false;
                event.stopPropagation()
            },
            freezeVp(e) {
                e.preventDefault()
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
