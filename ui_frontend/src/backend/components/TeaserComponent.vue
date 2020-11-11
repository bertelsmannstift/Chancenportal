<template>
    <article class="teaser" :class="className">
        <div class="teaser__img">
            <div></div>
        </div>
        <div class="teaser__text">
            <h1 class="teaser__headline">Welche Chancen bietet meine Stadt</h1>
            <h2 class="teaser__subheadline">Angebote für junge Menschen und Familien in Rheda-Wiedenbrück</h2>
            <slot>{{loremIpsum(3)}}</slot>
        </div>
    </article>
</template>

<script>
    import ButtonComponent from './ButtonComponent.vue';

    export default {
        name: 'TeaserComponent',
        props: {
            theme: {
                default: '',
                type: String
            },
        },
        created() {
            this.className = this.theme ? 'teaser--' + this.theme : '';
        },
        components: {
            ButtonComponent
        }
    }
</script>

<style lang="scss">
    .teaser__img div {
        background-image: url(/img/dummy/Headerbild.jpg);
    }

    .teaser {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        .teaser__img {
            position: absolute;
            left:0;
            top:0;
            z-index: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;

            div {
                background-size: cover;
                background-position: center;
                position: absolute;
                left:0;
                top:0;
                z-index: 0;
                height: calc(100% + 10px);
                width: calc(100% + 10px);
                filter: blur(5px);
                margin: -5px;
            }
        }

        .teaser__subheadline {
            margin-bottom: 50px;
        }

        .search {
            width: calc(100% + 40px);
            margin: 0 -15px 0 -25px;
            position: relative;
            padding: 26px 60px;

            @include mq('sm') {
                padding: 15px;
            }

            &:before {
                content: " ";
                width: 0;
                height: 0;
                position: absolute;
                border-style: solid;
                border-width: 0 10px 10px 0;
                border-color: transparent #494949 transparent transparent;
                left: 0px;
                bottom: -10px;
            }
        }

        h1, h2 {
            color: $color-white;
        }
        .teaser__headline {
            margin-bottom: 10px;
            font-weight: bold;
        }
        .teaser__text {
            width: 100%;
            position: relative;
            z-index: 1;
            padding: 50px 15px 25px 15px;
            text-align: center;
            > div {
                min-height: 225px;
            }
        }
    }
</style>
