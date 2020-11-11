<template>
    <component :is="element" class="container" :class="className">
        <slot></slot>
        <div v-if="showMore" class="container__show-more"><a :href="showMore">Mehr Anzeigen</a></div>
    </component>
</template>

<script>
    export default {
        name: 'ContainerComponent',
        props: {
            element: {
                default: 'div',
                type: String
            },
            showMore: {
                default: null,
                type: String
            },
            theme: {
                default: '',
                type: String
            },
        },
        created() {
            this.className = this.theme ? 'container--' + this.theme : '';
            if (this.showMore) {
                this.className += ' container--more'
            }
        }
    }
</script>

<style lang="scss">
    @import "../../styles/globals/margin.scss";

    main > div > .container:first-child,
    main > .container:first-child {
        > h1 {
            margin-top: 40px;
            @include mq('sm') {
                margin-top: 20px;
            }
        }
    }

    .container {
        max-width: $content-max-width;
        margin: 0 auto;
        position: relative;
        z-index: 5;

        &.container--border {
            padding: 50px 0px;
            border-top: 1px solid $color-gray-light;
            border-bottom: 1px solid $color-gray-light;
        }

        &.container--more {
            position: relative;
            z-index: 4;
        }

        > h1, > h2, > h3, > h4 {
            text-align: center;
        }
    }

    .container__show-more {
        position: absolute;
        right: 0;
        top: 14px;
        padding-right: 15px;
        color: $color-yellow;
        a {
            color: $color-yellow;
            font-weight: bold;
        }
        @include icon($icon-angle-right, 'after') {
            position: absolute;
            right: 0;
            top: 3px;
        }
        @include mq('md') {
            position: relative;
            text-align: right;
            top: 0;
            margin: 15px 0 0 0;
        }
    }

    main > div > .container,
    main > custom-add-to-homescreen > .container,
    main > .container {
        @extend .margin;
        &:first-child {
            z-index: 6;
        }
    }

    .container-fluid {
        margin-right: auto;
        margin-left: auto;
        padding-right: $outer-margin-xs;
        padding-left: $outer-margin-xs;

        @each $breakpoint in $breakpoints {
            $_max-width: nth($breakpoint, 2);
            $_padding: nth($breakpoint, 4);

            @media screen and (max-width: $_max-width) {
                padding-right: $_padding;
                padding-left: $_padding;
            }
        }
    }

    @each $breakpoint in $breakpoints {
        $size: nth($breakpoint, 2);
        $container: nth($breakpoint, 3);

        @media only screen and (max-width: $size - 1) {
            .container {
                max-width: $container;
                margin: 0 auto;
            }
        }
    }
</style>
