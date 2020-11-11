<template>
    <header class="header">
        <container-component>
            <row-component>
                <col-component lg-5 sm-12>
                    <div class="header__logo">
                        <div class="header__logo__svg">
                            <a href="/startseite.html"><img src="/img/svg/Logo_StadtRW.svg" height="69" width="200"/></a>
                        </div>
                        <div class="header__logo__title">
                            <div>Chancenportal</div>
                        </div>
                    </div>
                </col-component>
                <col-component lg-7 sm-12 bottom-lg>
                    <menu-component></menu-component>
                    <custom-login-overlay url="/index.php" toggle-selector=".nav__item--login">
                        <div class="login-overlay__content">
                            <h3>Anmelden</h3>
                            <p>Melden Sie sich mit Ihrem Anbieterkonto an, um Angebote einzustellen und zu verwalten. </p>
                            <div>
                                <div class="input">
                                    <label class="input__label">E-Mail</label>
                                    <input type="email" name="email" class="input__field">
                                </div>
                                <div class="input">
                                    <label class="input__label">Passwort</label>
                                    <input name="password" type="password" class="input__field">
                                </div>
                                <div class="flex-col bottom-lg">
                                    <button-component element="button" type="submit" class="login-overlay__submit">
                                        Anmelden
                                    </button-component>
                                    <a href="" class="login-overlay__link">Passwort vergessen</a>
                                </div>
                            </div>
                        </div>
                        <div class="login-overlay__footer">
                            <div>Sie sind neu hier und haben noch kein Konto?</div>
                            <a href="/login-registrierung.html" class="login-overlay__link">Jetzt registrieren</a>
                        </div>
                    </custom-login-overlay>
                </col-component>
            </row-component>
        </container-component>
    </header>
</template>

<script>
    import ContainerComponent from "./ContainerComponent";
    import RowComponent from "./RowComponent";
    import ColComponent from "./ColComponent";
    import MenuComponent from "./MenuComponent";
    import ButtonComponent from "./ButtonComponent";

    export default {
        components: {
            ButtonComponent,
            MenuComponent,
            ColComponent,
            RowComponent,
            ContainerComponent
        },
        name: 'HeaderComponent'
    }
</script>

<style lang="scss">
    header.header {
        position: fixed;
        max-height: 100px;
        width: 100%;
        top: 0;
        left: 0;
        background-color: #fff;
        z-index: 60;
        > .container {
            border-bottom: 1px solid $color-gray-light;
        }
        .header__logo {
            display: flex;
            flex-direction: row;
            align-items: flex-end;
            margin: 15px 0;

            .header__logo__svg {
                border-right: 1px solid #000;
                padding-right: 15px;
                margin-right: 15px;
                position: relative;
                z-index: 9999;
                min-width: 126px;
                max-width: 216px;
                width: 100%;

                @include mq(1050px) {
                    max-width: 126px;
                }

                a {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    height: 100%;
                    img {
                        display: block;
                    }
                }
            }

            .header__logo__title {
                text-transform: uppercase;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                align-items: flex-end;
                position: relative;
                z-index: 9999;
                div {
                    font-family: $font-family-headline;
                }
                @include mq(1050px) {
                    @include font-size(11);
                }
            }
        }
    }
</style>
