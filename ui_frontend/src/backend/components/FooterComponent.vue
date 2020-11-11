<template>
    <footer>
        <container-component class="footer">
            <row-component>
                <col-component lg-3 md-12 margin-inner-sm>
                    <img src="/img/logo.png" alt="Bertelsmann Stiftung" width="200"/>
                </col-component>
                <col-component lg-3 md-12 middle-lg flex>
                    <div>&copy; BERTELSMANN STIFTUNG 2007</div>
                </col-component>
                <col-component footer__nav-wrapper lg-6 md-12 flex-row end-lg middle-lg start-md>
                    <nav>
                        <ul class="flex-row">
                            <li><a href="">ÜBER UNS</a></li>
                            <li><a href="">IMPRESSUM</a></li>
                            <li><a href="">AGB</a></li>
                            <li><a href="">DATENSCHUTZ</a></li>
                            <li><a href="">KONTAKT</a></li>
                        </ul>
                    </nav>
                </col-component>
            </row-component>
        </container-component>
    </footer>
</template>

<script>
    import ContainerComponent from "./ContainerComponent";
    import RowComponent from "./RowComponent";
    import ColComponent from "./ColComponent";

    export default {
        components: {
            ColComponent,
            RowComponent,
            ContainerComponent
        },
        name: 'FooterComponent'
    }
</script>

<style lang="scss">
    .footer {
        padding: 20px 0;
        border-top: 1px solid $color-gray-light;
        @include font-size($font-size-base-small);

        img {
            width: 200px;
        }

        &__navigation {
            ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-wrap: wrap;
                margin: 0 -15px;
            }

            li {
                padding: 0 15px 0 4px;
            }
        }

        @include mq(1160) {
            .footer__nav-wrapper {
                width: 100%;
                display: block;
                max-width: none;
                flex-basis: 100%;
                li {
                    margin: 20px 15px 0 0px;
                    &:last-child {
                        margin: 20px 15px 0 0px;
                    }
                }
            }
        }

        nav {
            ul {
                list-style: none;
                margin: 0;
                padding: 0;
                li {
                    margin: 0 15px;
                    &:last-child {
                        margin: 0 0 0 15px;
                    }
                    a {
                        display: inline-block;
                        padding-right: 10px;
                        position: relative;
                        @include font-size($font-size-base-small);
                        @include icon($icon-angle-right, 'after') {
                            position: absolute;
                            right: 0;
                            top: 2px;
                            display: inline-block;
                            height: 14px;
                            overflow: hidden;
                        }
                        &:hover:after {
                            text-decoration: none;
                        }
                    }
                }
            }
        }
    }

    .footer__lang {
        position: fixed;
        bottom: 69px;
        right: 0;
        text-align: center;
        z-index: 999;
        .footer__lang-inner {
            margin: 0 10px;
            position: relative;
            > div {
                display: inline-block;
                background-color: #fff;
                position: relative;
                float: right;
                padding: 5px 10px;
                border-radius: 10px;
            }
        }
    }
</style>
