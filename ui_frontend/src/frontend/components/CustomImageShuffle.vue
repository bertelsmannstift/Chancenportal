<template>
    <div ref="shuffle" class="custom-image-shuffle">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: 'CustomImageShuffle',
        methods: {
            getRandom(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min)) + min;
            }
        },
        mounted() {
            let images = $(this.$refs.shuffle).children();
            let index = this.getRandom(0, images.length);
            images.eq(index).css('display', 'block');
        }
    }
</script>

<style lang="scss">
    custom-image-shuffle {
        .custom-image-shuffle > *,
        .custom-image-shuffle > img {
            display: none;
        }

        .custom-image-shuffle > div {
            position: relative;

            img {
                display: block;
            }
        }
    }
</style>
