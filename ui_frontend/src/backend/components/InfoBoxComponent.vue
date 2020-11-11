<template>
    <div class="info-box">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: 'InfoBoxComponent'
    }
</script>

<style lang="scss">

    .info-box {
        position: relative;
        padding: 20px 20px 20px 56px;
        background-color: $color-gray-light;
        @include font-size(15, 22);
        @include icon($icon-info, 'before', $color-black) {
            @include font-size(20);
            position: absolute;
            left: 26px;
            top: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            flex-direction: row;
        }
    }
</style>
