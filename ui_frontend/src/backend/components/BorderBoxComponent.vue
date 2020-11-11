<template>
    <component :is="element" class="border-box" :href="(element === 'a' ? '#' : null)" :class="[(theme ? 'border-box--' + theme : '')]">
        <div class="border-box__content">
            <slot>
                <h2 class="border-box__headline">{{title ? title : loremIpsum(4)}}</h2>
                <div class="border-box__text">{{text ? text : loremIpsum(6)}}</div>
            </slot>
        </div>
        <div class="border-box__arrow"></div>
    </component>
</template>

<script>
    export default {
        name: 'BorderBoxComponent',
        props: {
            theme: {
                default: null,
                type: String
            },
            title: {
                default: null,
                type: String
            },
            text: {
                default: null,
                type: String
            },
            element: {
                default: 'a',
                type: String
            }
        }
    }
</script>

<style lang="scss">
    .border-box {
        border: 1px solid $color-gray-light;
        padding: 25px 40px 25px 25px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        position: relative;
        align-items: normal;

        .border-box__content {
            display: block;
            width: 100%;
        }
        .border-box__headline {
            margin-bottom: 5px;
        }
        .border-box__text {
            margin: 0;
        }
        &:hover {
            background-color: $color-yellow;
            text-decoration: none;
        }

        .border-box__text--new {
            color: $color-yellow;
            font-weight: bold;
        }

        &:hover {
            .border-box__text--new {
                color: #000;
            }
        }

        &.border-box--arrow {
            justify-content: flex-start;
            align-items: flex-start;

            .border-box__headline {
                margin-bottom: 20px;
            }
        }
        .border-box__arrow {
            @include icon($icon-angle-right, 'after', $color-black) {
                @include font-size(36);
                font-weight: bold;
            }

            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 5;
        }

        &.border-box--container {
            width: 100%;
            padding: 25px;
            .border-box__arrow {
                display: none;
            }
            &:hover {
                background-color: transparent;
            }
            .border-box__headline {
                font-family: $font-family-headline;
                font-weight: bold;
            }
        }
    }
</style>
