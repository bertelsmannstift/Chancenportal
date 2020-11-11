<template>
    <div class="input" :class="[className, {'input--error': error}]">

        <label class="input__label" v-if="label">{{label}}</label>

        <input v-if="type !== 'textarea'" class="input__field" :placeholder="placeholderText" :type="type" :name="name"
               :id="id" :required="required" :maxlength="maxLength" :disabled="disabled" :value="value">

        <textarea v-if="type === 'textarea'" :name="name" :id="id" class="input__field" :placeholder="placeholderText"
                  cols="30" rows="10"
                  :maxlength="maxLength" :style="{'height': minHeight + 'px', 'min-height': minHeight + 'px'}"
                  :required="required" :disabled="disabled" :value="value"></textarea>

        <div class="input__error" v-if="error && errorMsg">
            {{errorMsg}}
        </div>
    </div>
</template>

<script>
    import RowComponent from "./RowComponent";
    import ColComponent from "./ColComponent";

    export default {
        name: 'InputComponent',
        components: {ColComponent, RowComponent},
        props: {
            label: {
                default: null,
                type: String
            },
            placeholderText: {
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
            type: {
                default: 'text',
                type: String
            },
            name: {
                default: null,
                type: String
            },
            id: {
                default: null,
                type: String
            },
            value: {
                default: null,
                type: String
            },
            className: {
                default: '',
                type: String
            },
            error: {
                default: false,
                type: Boolean
            },
            disabled: {
                default: false,
                type: Boolean
            },
            required: {
                default: false,
                type: Boolean
            },
            errorMsg: {
                default: null,
                type: String
            },
        }
    }
</script>

<style lang="scss">
    .input {
        margin-bottom: 25px;

        .input__label {
            display: block;
            margin-bottom: 10px;
            @include font-size(16);
        }

        .input__field {
            color: $color-black;
            border: 1px solid $color-input;
            padding: 14px 16px;
            outline: none;
            width: 100%;

            &.input--error {
                border: 1px solid #d81018;
            }
        }

        textarea, .input__field--rte {
            resize: vertical;

            &.input--error {
                border: 1px solid #d81018;
                padding: 12px 16px;
            }
        }

        .input__field--rte {
            overflow-x: hidden;
            overflow-y: auto;
            height: 220px;
            min-height: 220px;

            &.input--error {
                border: 1px solid #d81018;
            }
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

        input[disabled] {
            background-color: #fbfbfb;
            cursor: no-drop;
        }
    }
</style>
