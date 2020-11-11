<template>
    <div class="media-player"
         :class="{'media-player--initstate': !played, 'media-player--no-controls': !controls, 'media-player--is-touch': isTouchDevice}">
        <div v-if="error" class="media-player__message">
            Error loading media player.
        </div>
        <div v-else>
            <div v-if="mediaType === 'video'">
                <video class="mejs" ref="player" :poster="poster" :preload="preload" :controls="controls">
                    <source v-if="sources" v-for="video in sourcesData" :src="video.src" :type="video.type">
                    <track v-if="tracks" v-for="track in tracksData" :srclang="track.srclang" :kind="track.kind"
                           :src="track.src">
                </video>
            </div>
            <div v-if="mediaType === 'audio'">
                <audio ref="player" :preload="preload" :controls="controls">
                    <source v-if="sources" v-for="audio in sourcesData" :src="audio.src" :type="audio.type">
                </audio>
            </div>
            <div v-if="!mediaType" class="media-player__message">
                Please add a media-type attribute (audio or video).
            </div>
        </div>
    </div>
</template>

<script>
    import 'mediaelement';
    import 'mediaelement/build/lang/de';

    export default {
        props: {
            lang: {
                default: 'de',
                type: String
            },
            sources: String,
            mediaType: String,
            controls: {
                default: true,
                type: Boolean
            },
            preload: {
                default: 'none',
                type: String
            },
            poster: String,
            options: String,
            tracks: String
        },
        data() {
            return {
                videoTags: [],
                audioTags: [],
                player: null,
                played: false,
                isTouchDevice: false,
                error: false
            }
        },
        methods: {
            onError(media, node) {
                this.error = true;
            },
            onSuccess(media, node, instance) {
                media.addEventListener('play', this.onPlay, false);
            },
            onPlay() {
                this.played = true;
            }
        },
        computed: {
            sourcesData() {
                return (this.sources && JSON.parse(this.sources)) || null;
            },
            tracksData() {
                return (this.tracks && JSON.parse(this.tracks)) || null;
            }
        },
        mounted() {
            if (this.lang) {
                mejs.i18n.language(this.lang);
            }

            let options = Object.assign({}, (this.options ? JSON.parse(this.options) : {}), {
                pluginPath: './assets/media/',
                stretching: 'responsive',
                classPrefix: 'mejs__',
                alwaysShowControls: true,
                tracksAriaLive: true,
                audioVolume: 'vertical',
                success: (media, node, instance) => this.onSuccess(media, node, instance),
                error: (media, node) => this.onError(media, node)
            });

            this.player = new MediaElementPlayer(this.$refs.player, options);
            this.isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints;
        },
        name: 'MediaPlayer'
    }
</script>

<style lang="scss">

    @import "../../styles/globals/margin.scss";
    @import "~mediaelement/build/mediaelementplayer.css";

    .media-player {
        @extend .margin;
        &__message {
            padding: 40px;
            text-align: center;
        }
    }

    .mejs-offscreen {
        border: 0;
        clip: rect(1px, 1px, 1px, 1px);
        -webkit-clip-path: inset(50%);
        clip-path: inset(50%);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
        word-wrap: normal;
    }

</style>
