<template>
    <div>
        <a v-if="active" class="share__item timetable__share-item" :class="{'share__item--active': active}" :href="'https://facebook.com/sharer/sharer.php?u=' + decodeURIComponent(url) + '&caption=' + decodeURIComponent(title)" target="_blank">
            <i class="icon-thumbs-up"></i>
        </a>
        <a v-if="active" class="share__item timetable__share-item" :class="{'share__item--active': active}" :href="'https://twitter.com/intent/tweet/?text=' + decodeURIComponent(title + ' ' + url)" target="_blank">
            <i class="icon-twitter"></i>
        </a>
        <a v-if="active" class="share__item timetable__share-item" :class="{'share__item--active': active}" :href="'mailto:?subject=' + title + '&body=' + decodeURIComponent(title + ' ' + url)">
            <i class="icon-envelope-o"></i>
        </a>
        <a href="#" @click.prevent.stop="active = !active">
            <slot></slot>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            /**
             * URL to share.
             * @var string
             */
            url: {
                type: String,
                default: window.location.href
            },

            /**
             * Sharing title, if available by network.
             * @var string
             */
            title: {
                type: String,
                default: ''
            },
        },
        data() {
            return {
                active: false,
            }
        },
        mounted() {

        },
        name: 'Sharer'
    }
</script>

<style lang="scss">

    .share__item {
        position: relative;
        margin-right: 10px;
        top: 2px;
        display: none;

        &:hover,&:focus,&:active {
            opacity: .7;
            text-decoration: none;
            color: $color-yellow-active;
        }
    }

    .share__action {
        &:hover,&:focus,&:active {
            opacity: .7;
        }
    }

    .share__item--active {
        display: inline-block;
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        -webkit-animation-name: rollIn;
        animation-name: rollIn;
    }
    @-webkit-keyframes rollIn {
        from {
            opacity: 0;
            -webkit-transform: translate3d(-100%, 0, 0) rotate3d(0, 0, 1, -120deg);
            transform: translate3d(-100%, 0, 0) rotate3d(0, 0, 1, -120deg);
        }

        to {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

    @keyframes rollIn {
        from {
            opacity: 0;
            -webkit-transform: translate3d(-100%, 0, 0) rotate3d(0, 0, 1, -120deg);
            transform: translate3d(-100%, 0, 0) rotate3d(0, 0, 1, -120deg);
        }

        to {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

</style>
