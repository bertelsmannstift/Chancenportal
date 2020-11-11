<template>
    <custom-menu v-if="mobile">
        <nav class="nav" :class="theme ? 'nav--' + theme : ''">
            <ul class="nav__items">
                <li class="nav__item" v-for="item in items"
                    :class="[item.className, item.active ? 'nav__item--active' : '']"><a
                    :href="item.href">{{item.title}}</a></li>
            </ul>
        </nav>
        <div class="nav__item--logout-mobile" style="display:none;"></div>
    </custom-menu>
    <nav v-else class="nav" :class="theme ? 'nav--' + theme : ''">
        <ul class="nav__items">
            <li class="nav__item" v-for="item in items"
                :class="[item.className, item.active ? 'nav__item--active' : '']"><a
                :href="item.href">{{item.title}}</a></li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: {
            items: {
                default: () => {
                    return [
                        {title: 'Angebote', href: '/angebot-uebersicht.html'},
                        {title: 'Anbieter', href: '/anbieter-uebersicht.html'},
                        {title: 'Angebot einstellen', href: '/mein-konto/neuesangebot.html'},
                        {title: 'Anmelden', href: '#', className: 'nav__item--login'},
                    ];
                },
                type: Array
            },
            mobile: {
                default: true,
                type: Boolean
            },
            theme: {
                default: '',
                type: String
            },
        },
        name: 'MenuComponent',
        data() {
            return {}
        },
    }
</script>


<style lang="scss">
    .nav {
        height: 100%;
        .nav__items {
            height: 100%;
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            .nav__item {
                margin-left: 42px;
                align-items: flex-end;
                justify-content: flex-end;
                display: flex;
                border-bottom: 4px solid transparent;

                @include mq('md') {
                    margin-left: 16px;
                }

                a {
                    text-align: right;
                    padding-bottom: 10px;
                    text-transform: uppercase;
                    font-weight: bold;
                    text-decoration: none;
                    display: block;
                    color: $color-main;
                    white-space: nowrap;
                    font-family: $font-family-headline;
                    &:hover, &:focus, &:active {
                        color: $color-main;
                    }
                    @include mq(1100px) {
                        @include font-size($font-size-base-small);
                    }
                }

                &.nav__item--login,
                &:last-child:not(:first-child) {
                    a {
                        color: $color-black;
                        padding-left: 25px;
                        position: relative;
                        text-transform: none;
                        @include icon($icon-user, $color: $color-black) {
                            position: absolute;
                            left: 0;
                            top: 1px;
                        }
                    }

                    &:hover {
                        border-bottom: 4px solid $color-black;
                    }
                }


                &.nav__item--active, &:hover {
                    border-bottom: 4px solid $color-main;
                }
            }

            .nav__item--logout-mobile {
                display: none;
                @include mq('sm') {
                    display: block;
                }
            }
        }

        &.nav--tab {
            padding: 45px 0 0;
            margin: 0 0 35px;

            @include mq('sm') {
                padding: 15px 0 0;
            }

            .nav__items {
                border-bottom: 1px solid $color-gray-light;
                height: auto;
                justify-content: flex-start;

                .nav__item {
                    margin-left: 0;
                    margin-right: 40px;

                    &:last-child {
                        a {
                            padding-left: 0;
                            &:before {
                                display: none;
                            }
                        }
                    }

                    a {
                        text-transform: none;
                        color: $color-black;
                        @include font-size($font-size-md-h3, $line-height-md-h3);
                        @include mq('sm') {
                            @include font-size($font-size-xs-h3, $line-height-xs-h3);
                        }
                    }

                    &.nav__item--active, &:hover {
                        border-bottom: 4px solid $color-yellow;

                        a {
                            color: $color-yellow;
                        }
                    }
                }

            }
        }
    }


</style>
