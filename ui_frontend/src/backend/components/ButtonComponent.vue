/**
* Name: Button
* Progress: 100
* Jira: BSTCP-4
*/
<template>
    <component :is="elm" :href="href" class="btn" :class="['btn--'+theme, (icon === '' ? '' : 'btn--icon'), classes]"
               :title="title" :type="type">
        <i v-if="icon !== ''" :class="['icon-' + icon]"></i>
        <span><slot>Button text</slot></span>
    </component>
</template>

<script>
    export default {
        name: 'ButtonComponent',
        props: {
            element: {
                default: 'a',
                type: String
            },
            icon: {
                default: '',
                type: String
            },
            theme: {
                default: 'primary',
                type: String
            },
            href: {
                default: null,
                type: String
            },
            title: {
                default: 'Lorem ipsum',
                type: String
            },
            type: {
                default: '',
                type: String
            },
            classes: {
                default: '',
                type: String
            }
        },
        data() {
            return {
                elm: null
            }
        },
        created() {
            this.elm = this.element;
            if(this.type === 'submit') {
                this.elm = 'button';
            }
        }
    }
</script>

<style lang="scss">
    .btn {
        position: relative;
        cursor: pointer;
        line-height: 1;
        border: none;
        outline: none;
        font-weight: bold;
        display: inline-block;
        text-decoration: none;
        text-align: center;
        border-radius: 0;
        font-family: Arial;
        background-color: $color-yellow;
        padding: 15px 20px;

        &[disabled] {
            opacity: 0.8;
            cursor: not-allowed;
        }

        > i {
            position: absolute;
            left: 19px;
            display: flex;
            align-items: center;
            height: 100%;
            top: 0;
        }

        &.btn--icon {
            padding: 15px 20px 15px 44px;
        }

        &:hover, &:focus, &:active {
            text-decoration: none;
            background-color: $color-yellow-active;
        }

        &--active {
            text-decoration: none;
            background-color: $color-yellow-active;
        }

        &--full {
            width: 100%;
        }

        &--small {
            padding: 5px 10px;
        }

        &--loading {
            position: relative;
            &:after {
                position: absolute;
                text-align: center;
                content: " ";
                display: block;
                width: 20px;
                height: 20px;
                margin: 1px;
                top: 9px;
                left: calc(50% - 17px);
                border-radius: 50%;
                border: 5px solid $color-black;
                border-color: $color-black transparent $color-black transparent;
                animation: lds-dual-ring 1.2s linear infinite;
            }
            span {
                visibility: hidden;
            }
        }
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
