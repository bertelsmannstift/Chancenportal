/**
* Name: Login
* Progress: 100
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" class="login-register" data-animation="fadeIn">
                <row-component>
                    <col-component lg-12 margin-inner>
                        <h1>Login</h1>
                    </col-component>
                </row-component>

                <row-component>
                    <col-component lg-6 sm-12 margin-sm>
                        <h4 class="login-register__headline">Als Anbieter registrieren</h4>

                        Sie sind bereits im Portal registriert und möchten ein Angebot einstellen oder bearbeiten? Nach der Anmeldung ist dies problemlos möglich.

                        <div class="login-register__gray-box">
                            <h4>Ihre Vorteile</h4>
                            <ul class="check-list">
                                <li>Anlegen und Verwalten des Anbieterprofils Ihrer Organisation</li>
                                <li>Erstellung und Verwaltung Ihrer Angebote</li>
                                <li>Anlegen weiterer Nutzer für Ihre Organisation</li>
                            </ul>
                        </div>
                    </col-component>
                    <col-component lg-offset-1 lg-5 sm-12 sm-offset-0>
                        <custom-ajax-form url="/mein-konto/uebersicht.html" ajax="false" method="post">
                            <input-component :error="true" error-msg="Bitte geben Sie eine korrekte E-Mail-Adresse ein." type="email" label="E-Mail*"></input-component>
                            <input-component type="password" label="Passwort*"></input-component>
                            <div class="flex end-lg">
                                <div>
                                    <button-component type="submit">Anmelden</button-component>
                                    <div><a href="" class="login-register__link">Passwort vergessen</a></div>
                                </div>
                            </div>

                            <p class="login-register__noaccount">Sie sind neu hier und haben noch kein Konto? <a href="" class="login-register__link">Jetzt registrieren</a></p>

                            <div class="login-register__required">* Pflichtfelder</div>
                        </custom-ajax-form>
                    </col-component>
                </row-component>
            </container-component>

        </main>
    </page-layout-component>
</template>

<script>
    import PageLayoutComponent from '../layouts/PageLayoutComponent.vue';
    import ContainerComponent from "../components/ContainerComponent";
    import RowComponent from "../components/RowComponent";
    import ColComponent from "../components/ColComponent";
    import KachelComponent from "../components/KachelComponent";
    import KachelTeaserComponent from "../components/KachelTeaserComponent";
    import ButtonComponent from "../components/ButtonComponent";
    import BorderBoxComponent from "../components/BorderBoxComponent";
    import TeaserComponent from "../components/TeaserComponent";
    import SearchComponent from "../components/SearchComponent";
    import KachelListComponent from "../components/KachelListComponent";
    import InputComponent from "../components/InputComponent";
    import MenuComponent from "../components/MenuComponent";

    export default {
        components: {
            MenuComponent,
            InputComponent,
            KachelListComponent,
            SearchComponent,
            TeaserComponent,
            BorderBoxComponent,
            ButtonComponent,
            KachelTeaserComponent,
            KachelComponent,
            ColComponent,
            RowComponent,
            ContainerComponent,
            PageLayoutComponent,
        },
        metaInfo: {
            title: 'Login / Registrierung'
        },
        name: 'LoginRegistrierung'
    }
</script>

<style lang="scss">
    .login-register {
        h1 {
            margin-bottom: 5px;
            margin-top: 70px;
        }

        .login-register__required {
            color: $color-gray-dark;
            @include font-size(16);
        }

        .login-register__gray-box {
            margin: 30px 0 0 0;
            padding: 40px;
            background-color: $color-gray-light;
            h4 {
                @include font-size(22);
            }
            ul {
                margin: 0;
                padding: 0;
                li {
                    list-style: none;
                    padding-left: 26px;
                    display: block;
                    position: relative;
                    margin-bottom: 10px;
                    &:last-child {
                        margin: 0;
                    }
                    @include icon($icon-check, 'before') {
                        position: absolute;
                        left: 0;
                        top: 3px;
                    }
                }
            }
        }

        .login-register__link {
            display: inline-block;
            padding-right: 10px;
            position: relative;
            font-weight: bold;
            margin-top: 5px;
            color: $color-yellow;
            @include icon($icon-angle-right, 'after') {
                color: $color-yellow;
                position: absolute;
                right: 0;
                top: 3px;
            }
        }

        .login-register__noaccount {
            margin-top: 20px;
        }

        .login-register__headline {
            font-weight: bold;
            font-family: $font-family;
        }
    }
</style>
