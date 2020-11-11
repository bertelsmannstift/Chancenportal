<template>
    <ul class="my-account-menu">
        <li><a href="/mein-konto/uebersicht.html" :class="{'my-account-menu--active': activeItem == 1}">Übersicht</a></li>
        <li><a href="/mein-konto/anbieterprofil.html" :class="{'my-account-menu--active': activeItem == 2}">Anbieterprofil</a></li>
        <li><a href="/mein-konto/nutzerverwaltung.html" :class="{'my-account-menu--active': activeItem == 3}">Nutzerverwaltung</a></li>
        <li><a href="/mein-konto/angebote.html" :class="{'my-account-menu--active': activeItem == 4}">Angebote</a></li>
        <li><a href="/mein-konto/neuesangebot.html" :class="{'my-account-menu--active': activeItem == 5}">Neues Angebot</a></li>
        <li><a href="/mein-konto/auswertungen.html" :class="{'my-account-menu--active': activeItem == 7}">Auswertungen</a></li>
        <li class="my-account-menu__spacer"></li>
        <li><a href="/mein-konto/persoenliche-daten.html" :class="{'my-account-menu--active': activeItem == 6}">Persönliche Daten</a></li>
        <li><a href="#">Abmelden</a></li>
    </ul>
</template>

<script>
    export default {
        name: 'MyAccountMenuComponent',
        props: ['activeItem'],
    }
</script>

<style lang="scss">
    .my-account-menu {
        margin: 0;
        padding: 0;
        li {
            border-top:1px solid $color-gray-light;
            list-style: none;
            padding: 0;
            margin: 0;
            display: block;
            a {
                display: block;
                padding: 15px 25px;
                font-weight: bold;
                &:hover {
                    text-decoration: none;
                    background-color: $color-yellow;
                }
            }

            &:last-child {
                a {
                    color: $color-yellow;
                    position: relative;
                    display: block;
                    @include icon($icon-arrow-right, 'before', $color-yellow) {
                        margin-right: 10px;
                        text-decoration: none;
                    };
                    &:hover {
                        background-color: transparent;
                        text-decoration: underline;
                    }
                }
            }
        }

        .my-account-menu--active {
            background-color: $color-yellow;
        }

        .my-account-menu__spacer {
            height: 54px;
        }
    }
</style>
