<template>
    <div class="kachel-teaser">
        <slot>{{loremIpsum(3)}}</slot>
        <div class="kachel-teaser__content">
            <h3 class="kachel-teaser__headline">{{title ? title : loremIpsum(3)}}</h3>
            <p class="kachel-teaser__text">{{text ? text : loremIpsum(12)}}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'KachelTeaserComponent',
        props: {
            title: {
                default: null,
                type: String
            },
            text: {
                default: null,
                type: String
            },
        },
    }
</script>

<style lang="scss">
    .kachel-teaser__headline {
        margin-bottom: 15px;
        font-weight: bold;
    }

    .kachel-teaser__content {
        padding: 25px 20px;
    }
</style>
