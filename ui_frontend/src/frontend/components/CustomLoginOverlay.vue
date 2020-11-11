<template>
    <transition name="fade">
        <div v-show="show" @click.stop class="login-overlay">
            <a href="#" @click.prevent="toggle()" class="login-overlay__close">x</a>

            <custom-ajax-form :url="url" :redirect-url="redirectUrl" method="post" content-selector=".login-overlay__content">
                <slot></slot>
            </custom-ajax-form>

        </div>
    </transition>
</template>

<script>
    import ButtonComponent from "../../backend/components/ButtonComponent";

    export default {
        components: {ButtonComponent},
        props: {
            toggleSelector: {
                type: String,
                default: '#selector'
            },
            redirectUrl: {
                default: null,
                type: String
            },
            url: {
                type: String,
                default: ''
            },
        },
        methods: {
            toggle() {
                this.show = !this.show;
                $(this.toggleSelector).toggleClass('nav__item--active');
            }
        },
        mounted() {
            $(this.toggleSelector).click((e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggle();
            });
            $('body').click(() => {
                this.show = false;
                this.$forceUpdate();
            });
        },
        data() {
            return {
                show: false
            }
        },
        name: 'CustomLoginOverlay'
    }
</script>

<style lang="scss">
    custom-login-overlay {
        display: block;
        position: absolute;
        top: 100%;
        right: 0;
        max-width: 500px;
        width: 100%;

        > .login-overlay__content,
        > .login-overlay__footer {
            display: none;
        }
    }

    .login-overlay__link {
        color: $color-yellow;
        display: inline-block;
        padding-right: 10px;
        position: relative;
        font-weight: bold;
        margin-top: 5px;
        @include icon($icon-angle-right, 'after') {
            position: absolute;
            right: 0;
            top: 3px;
        }
    }

    .login-overlay__footer {
        background-color: $color-gray-light;
        margin: 25px -30px -30px -30px;
        padding: 15px 30px;
    }

    .login-overlay__submit {
        min-width: 190px;
    }

    .login-overlay__close {
        display: none;
        position: absolute;
        right: 20px;
        top: 20px;
        @include font-size(36);
        @include mq(801px) {
            display: block;
        }
    }

    .login-overlay {
        padding: 30px;
        background-color: #fff;
        box-shadow: 1px 1px 18px rgba(193, 193, 193, 0.70);

        @include mq(801px) {
            display: block;
            position: fixed;
            top: 0;
            z-index: 10000;
            left: 0;
            right: auto;
            height: 100vh;
            max-width: none;
            width: 100%;
            overflow: auto;
            padding-bottom: 300px;
            .login-overlay {
                min-height: 100vh;
            }
        }
    }

    .login-overlay__content {
        position: relative;
        h3 {
            margin-bottom: 10px;
            font-weight: bold;
        }
        label {
            display: block;
            margin-bottom: 20px;
        }
        input {
            padding: 10px 10px;
            display: block;
            margin-top: 10px;
            width: 100%;
            outline: none;
            border: 1px solid $color-gray-light;
            &:focus {
                border: 1px solid $color-black;
            }
        }
    }
</style>
