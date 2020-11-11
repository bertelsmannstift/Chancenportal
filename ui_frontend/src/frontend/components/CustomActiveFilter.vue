<template>
    <div class="active-filter">
        <div class="active-filter__items" v-if="Object.keys(filters).length">

            <transition-group
                    name="custom-classes-transition"
                    enter-active-class=""
                    leave-active-class="">
                <div :key="index" v-for="(filterItems, index) in filters" class="active-filter__group"
                     :class="{'active-filter--hide-remove': hideDelete}">
                    <div v-for="(item, subIndex) in filterItems.items" v-if="!item.remove" class="active-filter__item">
                        <input v-if="showValue" type="hidden" :name="item.id" value="1"/>{{item.title}}<a href="#"
                                                                                                          v-if="!hideDelete"
                                                                                                          :title="deleteText"
                                                                                                          @click.prevent="removeItem(index, subIndex, item)"
                                                                                                          class="active-filter__item__remove"></a>
                    </div>
                </div>
            </transition-group>
        </div>

        <span class="active-filter__slot" v-if="$slots.default">
            <slot></slot>
        </span>
        <a v-if="!hideDeleteAll && countAll() > 1" href="#" @click.prevent="removeAll()"
           class="active-filter__delete-all">
            {{deleteAllText}}
        </a>
    </div>
</template>

<script>
    export default {
        props: ['hideDeleteAll', 'hideDelete', 'deleteAllText', 'deleteText', 'isSelected', 'showValue'],
        data() {
            return {
                filters: {},
                elements: {},
                selects: {}
            }
        },
        methods: {
            removeAll() {
                this.filters = {};
                this.$emit('update', this.filters);
            },
            countAll() {
                let count = 0;
                for (let i in this.filters) {
                    count += this.filters[i].items.length;
                }
                return count;
            },
            removeItem(i, j, item) {

                if (typeof this.filters[i].items[j].onClear !== "undefined") {
                    this.filters[i].items[j].onClear();
                } else if (typeof this.filters[i].onClear !== "undefined") {
                    this.filters[i].onClear(item);
                }

                this.filters[i].items.splice(j, 1);
                if (this.filters[i].items.length === 0) {
                    delete this.filters[i];
                }

                this.$forceUpdate();
                this.$emit('update', this.filters);
            }
        },
        mounted() {

            $(this.$root.$el.parentElement).on('add', (e, param) => {
                if(param.detail.id.toString() !== '') {
                    this.filters[param.detail.id] = {
                        id: param.detail.id,
                        onClear: param.detail.onClear,
                        items: param.detail.items.filter(it => it.id !== '')
                    };
                    this.$forceUpdate();
                }
            });

            if (this.isSelected) {
                this.filters = JSON.parse(this.isSelected);
            }
        },
        name: 'CustomActiveFilter'
    }
</script>

<style lang="scss">
    .active-filter {
        position: relative;
        z-index: 1;

        @include mq('sm') {
            min-height: 0;
        }

        &__group {
            display: inline;
        }

        &__slot {
            a {
                color: $color-black;
                text-decoration: none;
                &:after {
                    color: $color-black;
                }
            }
        }

        &__items {
            display: inline-block;
            > span {
                display: block;
            }
        }

        &__item {
            display: inline-block;
            background-color: $color-gray-light;
            position: relative;
            padding: 8px 35px 8px 12px;
            margin: 0 0 20px 10px;
            @include font-size(18, 18);
            @include mq('md') {
                margin: 10px 10px 0px 0;
            }
        }

        &--hide-remove {
            .active-filter__item {
                padding: 8px 12px;
            }
        }

        &__item__remove {
            position: absolute;
            top: 6px;
            right: 10px;
            cursor: pointer;
            &:after {
                content: "x"
            }
        }
        &__delete-all {
            display: inline-block;
            text-decoration: none;
            color: $color-black;
            @include font-size(18, 18);
            @include icon($icon-angle-right, 'before') {
                margin-right: 5px;
                margin-top: 2px;
            }
        }
    }
</style>
