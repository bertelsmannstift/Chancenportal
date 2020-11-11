<template>
    <div class="custom-menu" :class="{'custom-menu--open': menuOpen}">
        <button @click="openMenu" :class="{'is-active': menuOpen}"
                class="custom-menu__btn hamburger--collapse hamburger" type="button">
        <span class="hamburger-box">
            <span class="hamburger-inner"></span>
        </span>
        </button>
        <transition name="fade">
            <div v-show="menuOpen || isDesktop" class="custom-menu__items">
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: 'custom-menu',
        props: {
            show: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                menuOpen: false,
                isDesktop: true
            }
        },
        methods: {
            openMenu() {
                this.menuOpen = !this.menuOpen;
            }
        },
        watch: {
            show(val) {
                this.menuOpen = val;
            },
            menuOpen(val) {
                if (val && !this.isDesktop) {
                    window.document.body.style.position = 'fixed';
                    window.document.body.style.height = '100%';
                    window.document.body.style.width = '100%';
                    window.document.body.style.overflow = 'hidden';
                } else {
                    window.document.body.style.position = '';
                    window.document.body.style.height = '';
                    window.document.body.style.width = '';
                    window.document.body.style.overflow = '';
                }
            }
        },
        mounted() {
            $(window).resize(() => {
                this.isDesktop = $(window).width() > 801;
                this.$forceUpdate();
            });
            $(window).resize();
        }
    }
</script>

<style lang="scss">
    .fade-enter-active, .fade-leave-active {
        transition: opacity .2s ease-in-out;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

    custom-menu {
        display: block;
        height: 100%;
    }

    .custom-menu__items,
    .custom-menu {
        height: 100%;
    }

    .custom-menu__btn {
        display: none;
    }

    @include mq(801px) {

        .custom-menu__btn {
            display: block;
            position: absolute;
            top: 20px;
            right: 20px;
            outline: none;
            padding: 0;
        }

        .custom-menu {
            position: fixed;
            left: 0;
            top: 8px;
            z-index: 999;
            width: 100%;
            height: 99px;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            &.custom-menu--open {
                height: 100%;
            }
        }
        .custom-menu__items {
            background-color: #fff;
            display: block;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 85px 20px;
            ul.nav__items {
                text-align: left;
                display: block;
                li.nav__item {
                    margin-left: 0;
                    margin-bottom: 15px;
                    display: block;
                    text-align: left;
                    a {
                        text-align: left;
                        padding-bottom: 8px;
                    }
                }
            }
        }
    }
</style>
