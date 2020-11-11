<template>
    <figure v-if="sources" class="rbi" ref="rbi">
        <picture ref="rbisrc" :data-crop="cropData">
            <source v-for="(data, index) in sourcesData" v-if="index < Object.keys(sourcesData).length - 1" :key="index"
                    :srcset="data.src" :media="data.media">
            <img ref="rbiimg" :src="sourcesData[sourcesData.length-1].src" alt=""/>
        </picture>
    </figure>
</template>


<script>
    export default {
        replace: true,
        name: 'ResponsiveBackgroundImage',
        props: {
            sources: String,
            crop: String
        },
        data() {
            return {
                element: null,
                data: null
            }
        },

        computed: {
            sourcesData() {
                return (this.sources && JSON.parse(this.sources)) || null;
            },
            cropData() {
                return this.crop;
            }
        },

        methods: {

            updateImage() {
                let src = typeof this.data.img.currentSrc !== 'undefined' ? this.data.img.currentSrc : this.data.img.src;

                if (this.data.src !== src) {
                    this.data.src = src;

                    let query = $('<a/>').attr({href: this.data.src})[0].search,
                        focus = (query && query.indexOf('rbiFocus=')) ? query.split('rbiFocus=')[1].split('&')[0] : null,
                        style = {'background-image': 'url("' + this.data.src + '")'};

                    if (this.data.focus[focus]) {
                        style['background-position'] = this.data.focus[focus].x + ' ' + this.data.focus[focus].y;
                    }

                    this.element.css(style);
                }
            },

        },
        mounted() {
            this.element = $(this.$refs.rbi);
            this.data = {
                picture: $(this.$refs.rbisrc),
                img: this.$refs.rbiimg,
                focus: {},
                src: ''
            };

            /**
             * Calculate focus points (background-position percent) from Typo3 information about focus areas
             */
            if (this.data.picture.data('crop')) {
                $.each(this.data.picture.data('crop'), (i, obj) => {
                    if (obj.focusArea) {
                        this.data.focus[i] = {
                            x: (obj.focusArea.x + obj.focusArea.width / 2) * 100 + '%',
                            y: (obj.focusArea.y + obj.focusArea.height / 2) * 100 + '%'
                        };
                    }
                });
            }

            /**
             * Add load event listener to the image
             */
            if (this.data.img) {
                this.data.img.addEventListener('load', () => {
                    this.updateImage();
                });

                if (this.data.img.complete) {
                    this.updateImage();
                }
            }
        }
    }
</script>


<style lang="scss">

    .has-responsive-backgroundimage {
        position: relative;
    }

    .rbi {
        overflow: hidden;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;

        margin: 0;
        padding: 0;

        background-size: cover;
        background-position: 50% 50%;

        picture {
            display: none;
        }
    }

</style>
