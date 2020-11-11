<template>
    <div class="input" :class="[className, {'input--error': error}]">
        <label class="input__label" v-if="label">{{label}}</label>
        <div class="input__wrapper">
            <input ref="input" @blur="format()" class="input__field" :placeholder="placeholderText" type="text" :name="name" :required="required" v-model="inputValue" autocomplete="new-password">
        </div>

        <div class="input__error" v-if="error && errorMsg">
            {{errorMsg}}
        </div>
    </div>
</template>

<script>

    export default {
        name: 'CustomMapAutocomplete',
        props: {
            label: {
                default: null,
                type: String
            },
            placeholderText: {
                default: '',
                type: String
            },
            apiKey: {
                default: null,
                type: String
            },
            minHeight: {
                default: 120,
                type: [String, Number]
            },
            maxLength: {
                default: null,
                type: [String, Number]
            },
            name: {
                default: null,
                type: String
            },
            value: {
                default: '',
                type: String
            },
            className: {
                default: '',
                type: String
            },
            required: {
                default: false,
                type: Boolean
            },
            errorMsg: {
                default: null,
                type: String
            },
            error: {
                default: false,
                type: Boolean
            },
        },
        data() {
            return {
                inputValue: '',
            }
        },
        methods: {
            format() {
                let values = this.inputValue.toString().split(':');
                const defaultFormat = (h, m) => {

                    let hour = parseInt(h);
                    let minutes = parseInt(m);

                    if(isNaN(hour)) {
                        hour = 0;
                    }

                    if(isNaN(minutes)) {
                        minutes = 0;
                    }

                    if(hour < 0 || hour > 23) {
                        hour = '';
                    }
                    if(minutes < 0 || minutes > 59) {
                        minutes = '';
                    }
                    return [hour, minutes];
                };

                let hour = '';
                let minutes = '';

                if(values.length === 2) {
                    [hour, minutes] = defaultFormat(values[0], values[1]);
                } else {
                    values = values.toString();
                    if(values.toString().length === 4) {
                        [hour, minutes] = defaultFormat(values.substr(0, 2), values.substr(2, 4));
                    } else if(values.toString().length === 2) {
                        [hour, minutes] = defaultFormat(values.substr(0, 2), 0);
                    } else {
                        this.inputValue = '';
                    }
                }
                this.inputValue = (hour === '' ? '' : hour.toString().padStart(2, "0") + ':' + minutes.toString().padStart(2, "0"));
            }
        },
        mounted() {
            this.inputValue = this.value;
        }
    }
</script>

<style lang="scss">
    .input {
        margin-bottom: 15px;
        position: relative;

        .input__wrapper {
            position: relative;
        }

        .input__label {
            display: block;
            margin-bottom: 8px;
            @include font-size(16);
        }
        .input__field {
            color: $color-black;
            border: 1px solid $color-input;
            padding: 14px 16px;
            outline: none;
            width: 100%;
        }
        textarea, .input__field--rte {
            resize: vertical;
        }
        .input__field--rte {
            overflow-x: hidden;
            overflow-y: auto;
            height: 220px;
            min-height: 220px;
        }
        &.input--error {
            .input__label {
                color: #d81018;
            }
            .input__error {
                @include font-size(14);
                color: #d81018;
                padding-top: 5px;
            }
        }
    }
</style>
