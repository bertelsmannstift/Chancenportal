<template>
    <section data-animation="fadeIn" class="container addtohomescreen" v-show="isMobile">
        <h1 v-if="headline">{{headline}}</h1>
        <div class="row">
            <div class="col-lg-12">

                <ul>
                    <li v-if="isIOS">
                        <img :src="logoAppStore" @click="showOverlay" alt="" />
                    </li>
                    <li v-if="isAndroid">
                        <img :src="logoPlayStore" @click="showOverlay" alt="" />
                    </li>
                </ul>

                <div ref="overlay" class="addtohomescreen__overlay" @click="hideOverlay">
                    <div class="addtohomescreen__overlay__content">
                        <slot name="ios" v-if="isIOS"></slot>
                        <slot name="ios" v-if="isAndroid"></slot>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
    import BodyScroll from '../js/utils/PreventBodyScroll/BodyScroll.js';
    import '../js/utils/PreventBodyScroll/scss/bodyScroll.scss';
    import UserAgent from '../js/utils/UserAgent.js';

    export default {
        name: 'CustomAddToHomescreen',
        props: {
            headline: {
                default: '',
                type: String
            },
            logoAppStore: {
                default: '/img/app_store.svg',
                type: String
            },
            logoPlayStore: {
                default: '/img/play_store.png',
                type: String
            }
        },
        data() {
            return {
                isMobile: false,
                isIOS: false,
                isAndroid: false,
            }
        },
        methods: {
            showOverlay() {
                BodyScroll.disable('body > .addtohomescreen__overlay ');
                $('body').find('> .addtohomescreen__overlay').show();
            },

            hideOverlay() {
                BodyScroll.enable();
                $('body').find('> .addtohomescreen__overlay').hide();
            }
        },
        computed: {

        },
        mounted() {
            if(UserAgent.isMobile()) {
                this.isMobile = true;
            }

            console.log(UserAgent);

            if(UserAgent.isIOS()) {
                this.isIOS = true;
                $(this.$refs.overlay).addClass('addtohomescreen__overlay--ios');
            }

            if(UserAgent.isAndroid()) {
                this.isAndroid = true;
                $(this.$refs.overlay).addClass('addtohomescreen__overlay--android');
            }

            $('body').append($(this.$refs.overlay));
        }
    }
</script>

<style lang="scss">

    .addtohomescreen {
        ul {
            display: block;
            list-style-type: none;
            padding:0;
            text-align: center;

            li {
                padding:0 10px;
                margin:0;
                display: inline-block;

                img {
                    height: 45px;
                }
            }
        }

        .addtohomescreen--overlay {
            display:none;
        }
    }

    .addtohomescreen__overlay {
        position: fixed;
        left:50%;
        transform: translateX(-50%);
        border: 1px solid #ccc;
        background-color:#fff;
        box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.25);
        display:none;
        z-index: 10;
        overflow: visible !important;
        padding:50px 0 10px 0;

        &:after {
            position: absolute;
            width: 30px;
            height: 30px;
            background-color:#fff;
            content:'';
            z-index:1;
        }

        &:before {
            position: absolute;
            content: 'X';
            color: #ccc;
            z-index: 20;
            font-weight:bold;
            top:13px;
            right: 18px;
        }

        &.addtohomescreen__overlay--ios {
            bottom:30px;
            width:85vw;

            &:after {
                bottom:-15px;
                left:50%;
                transform: translateX(-50%) rotate(45deg);
                box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, .25);
            }
        }

        &.addtohomescreen__overlay--android {
            top:30px;
            width:97vw;

            &:after {
                top:-16px;
                right:10px;
                border-left: 1px solid #ccc;
                border-top: 1px solid #ccc;
                transform: rotate(45deg);
            }
        }
    }

    .addtohomescreen__overlay__content {
        position: relative;
        max-height:65vh;
        overflow:auto !important;
        padding:0 10px;
        @include font-size(18, 22);
        background-color:#fff;
        z-index:2;
    }
</style>
