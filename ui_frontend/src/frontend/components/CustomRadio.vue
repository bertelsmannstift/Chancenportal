/**
* Name: Radio
* Progress: 100
*/
<template>
    <div class="custom-radio" :class="[{'custom-radio--active': active}, (theme ? 'custom-radio--' + theme : '')]">
        <input type="hidden" :name="name" v-if="active" :value="value"/>
        <a href="#" @click.prevent="toggle" class="custom-radio__inner">
            <span class="custom-radio__check"></span>
            <span class="custom-radio__label">{{ label }}</span>
        </a>
    </div>
</template>

<script>
    import queryString from '../mixins/query-string';

    export default {
        mixins: [queryString],
        props: {
            id: {
                default: 'example_id',
                type: String
            },
            name: {
                default: 'example_name',
                type: String
            },
            hideSelector: {
                default: null,
                type: String
            },
            showSelector: {
                default: null,
                type: String
            },
            theme: {
                default: null,
                type: String
            },
            value: {
                default: 'example_value'
            },
            label: {
                default: 'Text',
                type: String
            },
            isChecked: {
                default: false,
                type: Boolean
            },
            disabledSelector: {
                default: '',
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
                if (this.hideSelector && val) {
                    $(this.hideSelector).hide();
                }

                if (this.showSelector && val) {
                    $(this.showSelector).show();
                }

                if (this.disabledSelector && val) {
                    $(this.disabledSelector).attr('is-disabled', false);
                } else if (this.disabledSelector && !val) {
                    $(this.disabledSelector).attr('is-disabled', true);
                }
            }
        },
        methods: {
            toggle() {
                $(this.$el).parent().parent().find('custom-radio[name="' + this.name + '"]').trigger('toggle');
                this.active = !this.active;
                this.$emit('select', [{id: this.id.toString(), title: this.label, remove: !this.active}]);

                if(this.submitOnChange) {
                    this.$nextTick(()=>{
                        $(this.$el).parents('form').submit();
                    });
                }
            }
        },
        mounted() {

            const toggleFunc = (event) => {
                if (!event.detail || (event.detail && !event.detail.remove)) {
                    this.active = false;
                    this.$forceUpdate();
                }
            };

            $(this.$root.$el.parentElement).bind('toggle', toggleFunc);

            if (this.isChecked) {
                $(this.$el).parent().parent().find('custom-radio[name="' + this.name + '"]').trigger('toggle');
                this.active = true;
            }

            if (window.location.hash !== '') {
                let initVal = this.queryString(this.name);

                if (initVal && initVal.toString().trim() === this.value.toString()) {
                    $(this.$el).parent().parent().find('custom-radio[name="' + this.name + '"]').trigger('toggle');
                    this.active = true;
                    setTimeout(() => {
                        this.$emit('select', [{id: this.id.toString(), title: this.label, remove: false}]);
                    }, 100);
                }
            }
        },
        name: 'CustomRadio'
    }
</script>

<style lang="scss">
    custom-radio {
        line-height: 1;
    }

    .custom-radio {
        display: inline-block;
        overflow: hidden;

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
            border-radius: 50%;
            display: block;
            width: 22px;
            height: 22px;
            background-color: #fff;
            border: 1px solid $color-yellow;
            position: relative;
            flex: 0 0 auto;
        }
        &__label {
            text-decoration: none;
            color: #7a7a7a;
        }
        &--active {
            .custom-radio__check {
                &:before {
                    background-color: $color-yellow-active;
                    content: " ";
                    border-radius: 50%;
                    line-height: 1;
                    position: absolute;
                    left: 5px;
                    top: 5px;
                    padding: 2px;
                    width: calc(100% - 14px);
                    height: calc(100% - 14px);
                    display: block;
                }
            }
            .custom-radio__label {
                color: $color-black;
            }
        }
        &.custom-radio--light {
            margin-right: 30px;
            margin-top: 10px;
            .custom-radio__check {
                width: 30px;
                height: 30px;
                border: 1px solid $color-input;
            }
        }
    }
</style>
