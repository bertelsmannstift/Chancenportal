<template>
    <div class="custom-tabs">
        <a v-for="item in itemData" :title="item.name" @click="setActive(item)" class="btn btn--primary btn--icon" :class="{'btn--active': item.active === true}">
            <i :class="['icon-' + item.icon]"></i>
            {{item.name}}
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            items: {
                type: Array,
                default: []
            },
        },
        mounted() {
            this.itemData = JSON.parse(this.items);
        },
        methods: {
            setActive(activeItem) {
                this.itemData.forEach((item)=>{
                   item.active = false;
                });

                activeItem.active = true;

                activeItem.actions.forEach((action)=>{
                    let element = document.querySelector(action.selector);

                    Object.keys(action.prop).forEach((k)=>{
                        element.setAttribute(k, action.prop[k]);
                    });
                });
            }
        },
        data() {
            return {
                itemData: []
            }
        },
        name: 'CustomTabs'
    }
</script>

<style lang="scss">
    .custom-tabs {
        a {
            display: inline-block;
            margin: 0 0 0 10px;

            @include mq('md') {
                margin: 0 15px 10px 0;
                &:last-child {
                    margin: 0;
                }
            }
        }

        @include mq('sm') {
            display: none;
        }
    }
</style>
