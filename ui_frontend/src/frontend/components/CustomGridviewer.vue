<template>
    <div class="grid-viewer" ref="gridviewer">
        <div class="grid-viewer__inner-wrapper">
            <div class="row">

                <div v-for="(n, index) in 12" class="col-xs-1" :title="['Column '+(index+1)]">
                    <div class="grid-viewer__col-sizer"></div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CustomGridviewer',
        methods: {
            init() {
                const $element = $(this.$refs.gridviewer);

                $(window).on('keydown', function (event) {
                    if ((event.ctrlKey || event.metaKey) && event.which === 86) {
                        $element.toggle();
                    }
                });
            }
        },
        mounted() {
            this.init();
        }
    }
</script>

<style lang="scss">

    .grid-viewer {
        display: none;
        pointer-events: none;
        * {
            pointer-events: none;
        }

        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        z-index: 100;
        width: 100%;

        > .row > *[class^="col"] {
            background-color: rgba(0, 255, 0, 0.3);
        }

        &__col-sizer {
            height: 100vh;
            background-color: rgba(255, 0, 0, 0.4);
        }

        &__inner-wrapper {
            position: relative;
            margin: 0 auto;
            background-color: rgba(155, 0, 155, 0.2);
            max-width: $content-max-width + ($outer-margin-xs * 2);

            @each $breakpoint in $breakpoints {
                $_min-width: nth($breakpoint, 2);
                $_outermargin: nth($breakpoint, 4);
                @media screen and (min-width: $_min-width) {
                    max-width: $content-max-width + ($_outermargin * 2);
                }
            }

            > *:not(section) {
                padding-left: $outer-margin-xs;
                padding-right: $outer-margin-xs;

                @each $breakpoint in $breakpoints {
                    $_min-width: nth($breakpoint, 2);
                    $_outermargin: nth($breakpoint, 4);
                    @media screen and (min-width: $_min-width) {
                        padding-left: $_outermargin;
                        padding-right: $_outermargin;
                    }
                }
            }
        }
    }
</style>
