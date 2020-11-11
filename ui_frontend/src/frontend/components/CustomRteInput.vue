<template>
    <div class="input input--rte" :class="[className, {'input--error': error}]">

        <div class="row">
            <div class="col-lg-4 col-sm-12 flex middle-lg">
                <label class="input__label" v-if="label">{{label}}</label>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="custom-rte">
                    <button class="custom-rte__btn" :class="{'custom-rte__btn--active': !!currentFormat.bold}" @click.prevent="bold()"><i class="icon-bold"></i></button>
                    <button class="custom-rte__btn" :class="{'custom-rte__btn--active': !!currentFormat.italic}" @click.prevent="italic()"><i class="icon-italic"></i></button>
                    <button class="custom-rte__btn" :class="{'custom-rte__btn--active': !!currentFormat.ol}" @click.prevent="toggleOL()"><i class="icon-list-ol"></i></button>
                    <button class="custom-rte__btn" :class="{'custom-rte__btn--active': !!currentFormat.ul}" @click.prevent="toggleUL()"><i class="icon-list-ul"></i></button>
                    <button class="custom-rte__btn" :class="{'custom-rte__btn--active': !!currentFormat.link}" @click.prevent="link()"><i class="icon-link"></i></button>
                    <div ref="slot" v-show="false">
                        <textarea :name="name" :required="required" :disabled="disabled" v-model="rteVal"></textarea>
                    </div>
                </div>
             </div>
        </div>

        <div ref="rte_field" :name="name" :id="id" contenteditable="true" class="input__field input__field--rte" :placeholder="placeholderText" cols="30"
             rows="10" :maxlength="maxLength" :style="{'height': minHeight + 'px', 'min-height': minHeight + 'px'}" v-html="value"></div>

        <div class="input__error" v-if="error && errorMsg">
            {{errorMsg}}
        </div>
    </div>
</template>

<script>
    import Squire from 'squire-rte';

    export default {
        name: 'CustomRteInput',
        props: {
            linkQuestion: {
                type: String,
                default: 'Bitte geben Sie die URL ein.'
            },
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
        },
        data() {
            return {
                sel: null,
                rte: null,
                rteVal: '',
                currentFormat: {

                },
            }
        },
        mounted() {
            this.rteVal = this.value;

            this.rte = new Squire(this.$refs.rte_field, {
                blockTag: 'div'
            });

            this.rte.setHTML(this.value);

            this.rte.addEventListener("willPaste", (event) => {
                let fragment = document.createDocumentFragment();
                let div = document.createElement('div');
                div.appendChild(event.fragment);
                div.innerHTML = $(div).text().replace("\r\n", '<br>').replace("\n", '<br>');
                fragment.appendChild(div);

                event.fragment = fragment;
            });

            this.rte.addEventListener('pathChange', (e) => {
                this.$nextTick(() => {
                    this.currentFormat.bold = this.rte.hasFormat('b');
                    this.currentFormat.italic = this.rte.hasFormat('i');

                    this.currentFormat.ul = this.rte.hasFormat('ul');
                    this.currentFormat.ol = this.rte.hasFormat('ol');

                    this.currentFormat.link = this.rte.hasFormat('a');
                    this.$forceUpdate();
                });
            });
            this.rte.addEventListener('input', (e) => {
                this.$nextTick(() => {
                    this.rteVal = this.rte.getHTML();
                    this.$forceUpdate();
                });
            });
        },
        methods: {
            bold() {
                if (this.currentFormat.bold){
                    this.rte.removeBold();
                }else{
                    this.rte.bold();
                }
            },
            italic() {
                if (this.currentFormat.italic){
                    this.rte.removeItalic();
                }else{
                    this.rte.italic();
                }
            },
            toggleOL() {
                if (this.currentFormat.ol){
                    this.rte.removeList();
                }else{
                    this.rte.makeOrderedList();
                }
            },
            toggleUL() {
                if (this.currentFormat.ul){
                    this.rte.removeList();
                }else{
                    this.rte.makeUnorderedList();
                }
            },
            link() {
                if (this.currentFormat.link){
                    this.rte.removeLink();
                }else{
                    let placeholder = 'http://';
                    const url = window.prompt(this.linkQuestion, placeholder);

                    if (url && url.length){
                        this.rte.makeLink(url);
                    }
                }
            }
        },
    }
</script>

<style lang="scss">
    .custom-rte {
        text-align: right;
        margin-bottom: 10px;
    }
    .custom-rte__btn {
        border: 0;
        width: 33px;
        height: 31px;
        padding-top: 2px;
        display: inline-block;
        line-height: 1;
        margin-left: 5px;
        cursor: pointer;
        background-color: $color-yellow;
        &:hover {
            background-color: $color-yellow-active;
        }
    }
    .input__field--rte {
        a {
            text-decoration: underline;
        }
    }
    .custom-rte__btn--active {
        background-color: $color-yellow-active;
    }
</style>
