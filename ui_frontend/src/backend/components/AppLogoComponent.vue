<template>
    <div class="applogo">
        <a href="/" class="applogo__link">
            <img src="/img/ui_interact.svg" alt=""/>
        </a>
    </div>
</template>

<style lang="scss">

    .applogo {
        display: inline-block;

        &__link {
            text-decoration: none;
            &:hover,
            &:visited,
            &:active {
                text-decoration: none;
            }

            img {
                max-width: 100%;
                width: 100%;
                height: auto;
            }
        }
    }
</style>
