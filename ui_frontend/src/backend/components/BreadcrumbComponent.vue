<template>
    <div class="breadcrumb">
        <a href="" v-for="item in items">{{item.name}}</a>
    </div>
</template>

<script>
    export default {
        name: 'BreadcrumbComponent',
        props: ['items']
    }
</script>

<style lang="scss">
    .breadcrumb {
        padding: 4px 0 40px;
        a {
            color: $color-yellow;
            font-weight: bold;
            position: relative;
            padding-right: 15px;
            margin-right: 15px;
            @include font-size(14);
            @include icon($icon-chevron-right, 'after', $color-yellow) {
                position: absolute;
                right: -5px;
                top: 4px;
                font-size: 10px;
            }
            &:last-child {
                &:after {
                    display: none;
                }
            }
        }
    }
</style>
