/**
* Name: Checkbox
* Progress: 100
*/
<template>
    <div ref="select" class="custom-select"
         :required="required"
         :class="[{'custom-select--active': active && !isDisabled, 'custom-select--disabled': isDisabled}, theme ? 'custom-select--' + theme : '', classes ? classes : '']">
        <input type="hidden" :name="id" v-if="!isDisabled" :value="active ? value : '0'"/>
        <a href="#" @click.prevent="toggle" class="custom-select__inner">
            <span class="custom-select__check"></span>
            <span class="custom-select__label">{{ label }}</span>
        </a>
    </div>
</template>

<script>
    import queryString from '../mixins/query-string';

    export default {
        mixins: [queryString],
        props: {
            id: {
                default: 'example',
                type: String
            },
            value: {
                default: 'value',
                type: [String, Number]
            },
            label: {
                default: 'Text',
                type: String
            },
            isChecked: {
                default: false,
                type: Boolean
            },
            isDisabled: {
                default: false,
                type: Boolean
            },
            showTag: {
                default: false,
                type: Boolean
            },
            showSelector: {
                default: null,
                type: String
            },
            hideSelector: {
                default: null,
                type: String
            },
            required: Boolean,
            classes: {
                default: null,
                type: String
            },
            theme: {
                default: null,
                type: String
            },
            submitOnChange: {
                default: false,
                type: Boolean
            },
        },
        data() {
            return {
                active: false,
            }
        },
        watch: {
            active(val) {
                if (this.showSelector && val) {
                    $(this.showSelector).show();
                } else if(this.showSelector) {
                    $(this.showSelector).hide();
                }
                if (this.hideSelector && val) {
                    $(this.hideSelector).hide();
                } else if(this.hideSelector) {
                    $(this.hideSelector).show();
                }
            },
            isDisabled(val) {
                if (val) {
                    this.active = false;
                    this.emitData();
                }
            }
        },
        methods: {
            toggle() {
                if (!this.isDisabled) {
                    this.active = !this.active;
                    this.emitData();

                    if(this.submitOnChange) {
                        this.$nextTick(()=>{
                            $(this.$refs.select).parents('form').submit();
                        });
                    }
                }
            },
            emitData() {
                if(this.showTag) {
                    $('custom-active-filter').trigger('add', [{
                        detail: {
                            id: this.id,
                            onClear: this.toggle,
                            items: [{id: this.id.toString(), title: this.label, remove: !this.active}]
                        }
                    }]);
                }
            }
        },
        mounted() {

            let toggleFunc = (event) => {
                if (!event.detail.remove) {
                    this.active = false;
                    this.$forceUpdate();
                }
            };

            if (this.isChecked) {
                this.active = true;
            }

            if (this.$root.$el.parentElement.addEventListener) {
                this.$root.$el.parentElement.addEventListener('toggle', toggleFunc, false);
            } else if (this.$root.$el.parentElement.attachEvent) {
                this.$root.$el.parentElement.attachEvent('ontoggle', toggleFunc);
            }

            if (window.location.hash !== '') {
                let initVal = this.queryString(this.id);

                setTimeout(() => {
                    if (initVal && initVal.toString().trim() === this.value.toString() && !this.isDisabled) {
                        this.active = true;
                        this.emitData();
                    }
                }, 200);
            }
        },
        name: 'CustomSelect'
    }
</script>

<style lang="scss">
    custom-select {
        line-height: 1;
        display: inline-block;
    }

    .custom-select {
        display: inline-block;
        overflow: hidden;
        &--disabled {
            opacity: .8;
        }
        &__inner {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            text-decoration: none;
            &:hover, &:focus, &:active {
                text-decoration: none;
            }
        }
        &__check {
            margin-right: 14px;
            display: block;
            width: 22px;
            height: 22px;
            background-color: #fff;
            border: 1px solid $color-yellow;
        }
        &__label {
            text-decoration: none;
            color: #7a7a7a;
        }
        &--active {
            .custom-select__check {
                @include icon($icon-check, 'before') {
                    line-height: 1;
                    position: relative;
                    left: 0;
                    color: $color-yellow-active;
                    padding: 2px;
                    font-size: 0.9rem;
                    display: block;
                }
            }
            .custom-select__label {
                color: $color-black;
            }
        }
        &.custom-select--light {
            margin-top: 12px;

            @include mq('sm') {
                margin-top: 0;
            }

            .custom-select__check {
                width: 30px;
                height: 30px;
                background-color: #fff;
                border: 1px solid $color-input;
            }

            &.custom-select--active {
                .custom-select__check {
                    &:before {
                        font-size: 1.3rem;
                    }
                }
            }
        }
    }
</style>
