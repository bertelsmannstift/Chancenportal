<template>
    <div class="custom-new-line">
        <div v-show="false" ref="slot" class="custom-new-line__org_clone"><slot></slot></div>
        <div v-for="(clone, index) in clones" :key="clone.id" class="custom-new-line__line">
            <a href="#" @click.prevent="remove(index)" v-if="index !== 0" class="custom-new-line__removelink"><i class="icon-trash-o"></i></a>
            <div v-html="clone.html" class="custom-new-line__clone"></div>
        </div>
        <a v-if="!disabled" href="#" class="custom-new-line__addlink" @click.prevent="addLine"><i class="icon-plus"></i> {{linkText}}</a>
    </div>
</template>

<script>

    export default {
        name: 'CustomNewLine',
        props: {
            linkText: {
                default: 'weitere Zeile hinzufügen',
                type: String
            },
            items: {
                default: null,
                type: String
            },
            limit: {
                default: null,
                type: Number
            }
        },
        data() {
            return {
                counter: 0,
                element: null,
                disabled: false,
                clones: []
            }
        },
        watch: {
            isDisabled(val) {
                this.disabled = val;
            },
            limit(val) {
                if(val) {
                    this.clones = this.clones.splice(0, val);
                }

                if(this.limit && this.clones.length >= this.limit) {
                    this.disabled = true;
                } else {
                    this.disabled = false;
                }
            }
        },
        methods: {
            addLine() {
                let html = this.element.replace(/\[\d\]/ig, '[' + this.counter + ']');
                this.clones.push({
                    id: this.counter,
                    html: html
                });

                this.counter++;
                if(this.limit && this.clones.length >= this.limit) {
                    this.disabled = true;
                } else {
                    this.disabled = false;
                }
            },
            remove(index) {
                this.clones.splice(index, 1);
                this.counter--;
                if(this.limit && this.clones.length >= this.limit) {
                    this.disabled = true;
                } else {
                    this.disabled = false;
                }
            }
        },
        mounted() {
            this.elements = this.$slots.default ? this.$slots.default : null;
            if(this.elements) {
                this.element = $(this.$refs.slot).children().filter(':not([data-item])').get(0).outerHTML;

                let items = $(this.$refs.slot).children().filter('[data-item]');

                for(let item of items) {
                    let html = item.outerHTML.replace(/\[\d\]/ig, '[' + this.counter + ']');
                    this.clones.push({
                        id: this.counter,
                        html: html
                    });
                    this.counter++;
                }

                items.remove();

                if(this.clones.length === 0) {
                    this.addLine();
                }
            }

            setTimeout(()=>{
                $(this.$refs.slot).find('input,textarea').val('').removeAttr('id').removeAttr('class').attr('disabled', 'disabled');
            }, 500);

            this.disabled = this.isDisabled;
        }
    }
</script>

<style lang="scss">
    .custom-new-line__line {
        position: relative;
    }
    .custom-new-line__removelink {
        position: absolute;
        left: -32px;
        top: 0;
        height: 100%;
        font-size: 22px;
        display: flex;
        align-items: center;
        color: $color-yellow;
        @include mq('sm') {
            position: relative;
            left: 0;
            top: 0;
        }
    }
    custom-new-line {
        display: block;
    }
    .custom-new-line__addlink {
        color: $color-yellow;
        font-weight: bold;
        display: block;
        padding-left: 18px;
        position: relative;
        i {
            @include font-size(14);
            position: absolute;
            left: 0;
            top: 4px;
        }
    }
</style>
