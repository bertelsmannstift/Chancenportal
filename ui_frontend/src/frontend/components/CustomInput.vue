<template>
    <input ref="input" type="text" :class="cssClass" @blur="changeTag" @keyup.enter="changeTag" :name="id" v-model="val" :placeholder="placeholder"/>
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
            placeholder: {
                default: '',
                type: String
            },
            cssClass: {
                default: '',
                type: String
            },
            regexReplace: {
                default: null,
                type: String
            },
            showTag: {
                default: false,
                type: Boolean
            },
            submitOnChange: {
                default: false,
                type: Boolean
            },
        },
        watch: {
          val(val) {
              if(this.regexReplace !== null) {
                  let re = new RegExp(this.regexReplace, 'i');
                  this.val = val.replace(re, '');
              }
          }
        },
        data() {
            return {
                val: ''
            }
        },
        methods: {
            changeTag() {
                if(this.showTag) {
                    $('custom-active-filter').trigger('add', [{
                        detail: {
                            id: this.id,
                            onClear: ()=>{
                                this.val = '';
                                this.$nextTick(()=>{
                                    $(this.$refs.input).parents('form').submit();
                                });
                            },
                            items: [{id: this.id.toString(), title: this.val, remove: this.val.trim() === ''}]
                        }
                    }]);
                }
                if(this.submitOnChange && this.val.trim() !== '') {
                    this.$nextTick(()=>{
                        $(this.$refs.input).parents('form').submit();
                    });
                }
            }
        },
        mounted() {
            if (window.location.hash !== '') {
                let initVal = this.queryString(this.id);
                this.val = initVal;
                setTimeout(()=>{
                    if(initVal && initVal !== '') {
                        this.changeTag();
                    }
                }, 1000);
            }
        },
        name: 'CustomInput'
    }
</script>

<style lang="scss">

</style>
