<template>
    <section class="stageslider has-responsive-backgroundimage">
        <div class="stageslider__inner">
            <div class="stageslider__items" ref="stageslider">
                <slot>
                    <div class="">Slide #1</div>
                    <div class="">Slide #2</div>
                    <div class="">Slide #3</div>
                    <div class="">Slide #4</div>
                </slot>
            </div>
        </div>
    </section>
</template>


<script>
    export default {
        name: 'StageSlider',
        props: {
            options: String
        },
        data() {
            return {
                $sliderElement: null,
                slickOptions: {
                    rows: 0, // don't remove
                    dots: true
                }
            }
        },
        methods: {
            init() {
                let _options = this.slickOptions;
                if (this.options) {
                    _options = $.extend(_options, JSON.parse(this.options));
                }
                this.$sliderElement = $(this.$refs.stageslider).slick(_options);
            }
        },
        mounted() {
            require(['slick-carousel', 'slick-carousel/slick/slick.scss'], () => {
                this.init();
            });
        }
    }
</script>

<style lang="scss">
    @import "../../styles/globals/margin.scss";

    .stageslider {

        @extend .margin;

        background-color: $color-gray-light;
        height: calc(100vh - 121px);

        .stageslider__inner {
            position: relative;
            z-index: 2;
            height: 100%;
        }

        &__items,
        &__item,
        .slick-list,
        .slick-track {
            height: 100%;
        }

        .slick-slide {
            > div {
                height: 100%;
            }
        }

        .slick-prev,
        .slick-next {
            z-index: 2;
            position: absolute;
            top: 50%;
            left: 40px;
            transform: translateY(-50%);
        }

        .slick-next {
            left: auto;
            right: 40px;
        }

    }

    .slick-prev,
    .slick-next {
        z-index: 1;
        position: absolute;
        display: block;
        line-height: 0px;
        font-size: 0px;
        cursor: pointer;
        background: transparent;
        color: transparent;
        top: 50%;
        -webkit-transform: translate(0, -50%);
        -ms-transform: translate(0, -50%);
        transform: translate(0, -50%);
        padding: 0;
        border: none;
        outline: none;

        &:hover, &:focus {
            outline: none;
            background: transparent;
            color: transparent;
            &:before {
                opacity: .7;
            }
        }

        &.slick-disabled:before {
            opacity: .4;
        }

        &:before {
            font-size: 25px;
            color: $color-white;
            opacity: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            @include mq('lm') {
                font-size: 40px;
            }
        }
    }

    .slick-prev {
        left: 10px;
        @include icon($icon-chevron-left);
        @include mq('lm') {
            left: -50px;
        }
        @include mq('lg') {
            left: -100px;
        }
    }

    .slick-next {
        right: 10px;
        @include icon($icon-chevron-right);
        @include mq('lm') {
            right: -50px;
        }
        @include mq('lg') {
            right: -100px;
        }
    }

    .slick-dots {
        z-index: 3;
        position: absolute;
        bottom: 40px;
        width: 100%;
        margin: 0 0;
        padding: 0;
        list-style-type: none;
        text-align: center;

        li {
            margin: 0px 7px 0 7px;
            padding: 0;
            display: inline-block;

            button {
                padding: 0;
                text-indent: 10000000px;
                width: 15px;
                height: 15px;
                border-radius: 50%;
                background-color: transparent;
                cursor: pointer;
                background-color: $color-gray-dark;
                border: 1px solid $color-white;

                &:focus {
                    outline: none;
                }
            }

            &.slick-active button {
                background-color: $color-gray-light;
                border: 1px solid $color-white;
            }
        }
    }

</style>
