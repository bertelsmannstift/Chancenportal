/**
* Name: Kachel
* Progress: 99
*/
<template>
    <div :data-lat="lat" :data-lng="lng" v-if="type === 'colorbox'" class="kachel"
         :class="[themeName ? 'kachel--theme-' + (offer ? offer.theme : themeName) : '', {'kachel--light': light}, {'kachel--with-image': image}]"
         :style="{'background-image': (image ? 'url(' + image + ')' : 'none')}">

        <a :href="link">
            <div v-if="image && gradient !== false" class="kachel__gradient"></div>
            <div class="kachel__inner" :class="{'kachel__inner--nocontent': showContent === false}">
                <div v-if="kategorieName" class="kachel__category">{{offer ? offer.category : kategorieName}}</div>
                <div v-else class="kachel__category">{{title ? title : (offer ? offer.category : loremIpsum(3))}}</div>
                <div v-if="showContent !== false" class="kachel__content">
                    <h3 class="kachel__headline">
                        {{ title ? title : (offer ? offer.title : loremIpsum(2)) }}
                    </h3>
                    <h4 class="kachel__subheadline">{{ text ? text : (offer ? offer.text : loremIpsum(2)) }}</h4>
                    <p v-if="!offer">{{text2 ? text2 : loremIpsum(6)}}</p>
                    <div v-if="!event" class="kachel__date">{{date ? date : (offer ? offer.date : 'Heute, 01.01.2018')}}</div>
                    <div v-if="event" class="kachel__footer">
                        <div class="kachel__location">{{offer ? offer.district : 'Alle Stadtteile'}}</div>
                        <div class="kachel__user" v-if="(offer && offer.targetGroup) || !offer">{{offer ? offer.targetGroup : 'für Mütter und Kinder'}}</div>
                        <div class="kachel__calendar">{{offer ? offer.date : 'Jeden Montag'}}</div>
                        <div class="kachel__time">{{offer ? offer.time + ' Uhr' : '15:00 - 18:00 Uhr'}}</div>
                    </div>
                </div>
            </div>
            <div class="kachel__arrow"></div>
        </a>
        <div class="kachel__map-arrow"></div>
    </div>

    <div v-else :data-lat="lat" :data-lng="lng" class="kachel kachel--image-text">

        <a :href="link">

            <div class="kachel__text">
                <h3 class="kachel__headline">
                    {{title ? title : loremIpsum(2)}}
                </h3>
                <p>{{text ? text : loremIpsum(15)}}</p>
            </div>
            <div v-if="image" class="kachel__image-wrapper">
                <div class="kachel__image"
                     :style="{'background-image': (image ? 'url(' + image + ')' : 'none')}"></div>
            </div>
            <div class="kachel__arrow"></div>
        </a>

    </div>
</template>

<script>
    export default {
        name: 'KachelComponent',
        props: {
            image: {
                default: '',
                type: String
            },
            light: {
                default: false,
                type: Boolean
            },
            theme: {
                default: '',
                type: String
            },
            offer: {
                default: null,
                type: Object
            },
            lat: {
                default: null,
                type: [String, Number]
            },
            lng: {
                default: null,
                type: [String, Number]
            },
            type: {
                default: 'colorbox',
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
            date: {
                default: null,
                type: String
            },
            text2: {
                default: null,
                type: String
            },
            link: {
                default: '',
                type: String
            },
            gradient: {
                default: false,
                type: Boolean
            },
            showContent: {
                default: true,
                type: Boolean
            },
            event: {
                default: false,
                type: Boolean
            },
        },
        data() {
            return {
                themeName: 1,
                kategorieName: null,
            }
        },
        created() {
            let min = 1;
            let max = 5;
            this.themeName = this.theme ? false : Math.round((Math.random() * (max - min)) + min);

            if (this.themeName === 1) {
                this.kategorieName = 'Bildung & Betreuung';
            } else if (this.themeName === 2) {
                this.kategorieName = 'Freizeit & Kultur';
            } else if (this.themeName === 3) {
                this.kategorieName = 'Übergang Schule & Beruf';
            } else if (this.themeName === 4) {
                this.kategorieName = 'Beratung & Unterstützung';
            } else if (this.themeName === 5) {
                this.kategorieName = 'Vorsorge & Gesundheit';
            }
        }
    }
</script>

<style lang="scss">

    .kachel {
        flex: 1 1 auto;
        position: relative;
        text-align: left;
        height: 100%;
        background-size: cover;
        background-position: center;

        .kachel__subheadline {
            margin: 0 0 15px;
            color: $color-white;
            hyphens: auto;

            /* Chrome, for some reason, doesn't hyphenate the last word, so add something invisible to fix this. */
            &::after {
                display: inline-block;
                width: 0;
                height: 0;
                visibility: hidden;
                overflow: hidden;
                content: ' .';
            }
        }

        a {
            display: block;
            height: 100%;
            position: relative;
            &:hover, &:active, &:focus {
                text-decoration: none;
            }
        }

        .kachel__location {
            position: relative;
            padding-left: 28px;
            padding-right: 10px;
            @include icon($icon-map-marker, 'before', #fff) {
                @include font-size(20);
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        .kachel__offers {
            position: relative;
            padding-left: 28px;
            padding-right: 10px;
            @include icon($icon-ticket, 'before', #fff) {
                @include font-size(20);
                position: absolute;
                left: -3px;
                top: 0;
            }
        }

        .kachel__user {
            position: relative;
            padding-left: 28px;
            padding-right: 10px;
            @include icon($icon-user, 'before', #fff) {
                @include font-size(20);
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        .kachel__calendar {
            position: relative;
            padding-left: 28px;
            padding-right: 10px;
            @include icon($icon-calendar, 'before', #fff) {
                @include font-size(20);
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        .kachel__time {
            position: relative;
            padding-left: 28px;
            padding-right: 10px;
            @include icon($icon-clock-o, 'before', #fff) {
                @include font-size(20);
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        .kachel__footer {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            color: #fff;
            > div {
                width: 50%;
                margin-top: 10px;
            }

            @include mq('sm') {
                flex-direction: column;
                > div {
                    width: 100%;
                }
                .kachel__user {
                    white-space: nowrap;
                    text-overflow: ellipsis;
                    overflow: hidden;
                }
            }
        }

        .kachel__inner--nocontent {
            min-height: 294px;
        }

        .kachel__arrow {
            @include icon($icon-angle-right, 'after', #fff) {
                @include font-size(30);
            }

            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 5;
        }

        .kachel__inner {
            padding-top: 18px;
            position: relative;
            z-index: 2;
        }

        .kachel__gradient {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            z-index: 0;
            left: 0;
            background: linear-gradient(to bottom, $color-yellow 0%, rgba(30, 87, 153, 0) 100%);
        }

        .kachel__category {
            width: calc(100% + 10px);
            position: relative;
            left: -10px;
            top: 0px;
            margin-bottom: 15px;
            padding: 10px 30px;
            background-color: $color-yellow;
            color: $color-white;
            text-transform: uppercase;
            @include font-size(14);
            &:before {
                content: " ";
                width: 0;
                height: 0;
                position: absolute;
                border-style: solid;
                border-width: 0 10px 10px 0;
                border-color: transparent #cc8d00 transparent transparent;
                left: 0px;
                bottom: -10px;
            }
        }

        .kachel__headline {
            word-break: break-word;
            color: #fff;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            font-family: $font-family-headline;
            @include font-size(24, 28);
            hyphens: auto;

            /* Chrome, for some reason, doesn't hyphenate the last word, so add something invisible to fix this. */
            &::after {
                display: inline-block;
                width: 0;
                height: 0;
                visibility: hidden;
                overflow: hidden;
                content: ' .';
            }
        }

        p {
            color: #fff;
        }

        .kachel__date {
            margin-top: 40px;
            color: #fff;
        }

        .kachel__content {
            padding: 5px 45px 20px 20px;
        }

        &.kachel--with-image {
            border: 0;
        }

        &:hover {
            .kachel__category {
                background-color: $color-yellow-active;
            }

            .kachel__gradient {
                background: linear-gradient(to bottom, $color-yellow 0%, rgba(0, 158, 227, 0) 100%);
            }
        }

        &.kachel {

            background-color: $color-yellow-active;

            .kachel__gradient {
                background: linear-gradient(to bottom, $color-yellow-active 0%, rgba(0, 158, 227, 0) 100%);
            }

            &.kachel--image-text {
                background-color: #fff;
            }

            p,
            .kachel__arrow,
            .kachel__date,
            .kachel__subheadline,
            .kachel__footer,
            .kachel__headline {
                color: $color-black;
                &:after {
                    color: $color-black;
                }
                :before {
                    color: $color-black;
                }
            }

            &:hover {
                background-color: $color-yellow;

                .kachel__category {
                    background-color: $color-yellow-active;
                }

                .kachel__gradient {
                    background: linear-gradient(to bottom, $color-yellow 0%, rgba(0, 158, 227, 0) 100%);
                }

            }
        }

        &--image-text {
            border: 1px solid $color-gray-light;
            p,
            .kachel__headline {
                color: $color-black;
            }
            .kachel__arrow {
                @include icon($icon-angle-right, 'after', $color-black) {
                    @include font-size(30);
                }
            }
            .kachel__image-wrapper {
                flex: 1;
                width: 50%;
                display: flex;
                justify-content: center;
                align-items: center;

                @include mq('sm') {
                    display: none;
                }
            }

            .kachel__image {

                height: 200px;
                width: 200px;
                background-repeat: no-repeat;
                background-size: 90%;
                margin: 10px 10px 10px 10px;
                background-position: center;
                background-color: $color-white;
                border-radius: 0%;

                @include mq('sm') {
                    margin: 15px;
                }
            }
            .kachel__headline {
                margin-bottom: 20px;
            }
            .kachel__text {
                width: 50%;
                padding: 30px;
                flex: 0 1 auto;
                @include mq('sm') {
                    width: 100%;
                }
            }
            > a {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
            }
            &:hover {
                background-color: $color-yellow;
            }
        }

        &.kachel--light {
            background-color: #fff;
            border: 1px solid $color-gray-light;

            p,
            .kachel__arrow,
            .kachel__subheadline,
            .kachel__footer,
            .kachel__headline {
                color: $color-black;
                &:after {
                    color: $color-black;
                }
            }

            &:hover {
                p,
                .kachel__arrow,
                .kachel__subheadline,
                .kachel__footer,
                .kachel__headline {
                    color: $color-white;
                    &:after, &:before {
                        color: $color-white;
                    }
                }

                .kachel__arrow:before,
                .kachel__footer > div:before,
                .kachel__footer > div:after {
                    color: $color-white;
                }
            }
        }
    }
</style>
