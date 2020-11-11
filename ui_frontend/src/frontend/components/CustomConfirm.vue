<template>
    <span class="custom-confirm">
        <slot></slot>
    </span>
</template>

<script>
    export default {
        props: {
            text: {
                type: String,
                default: 'Eintrag löschen?'
            },
            redirectUrl: {
                type: String,
                default: null
            },
            reload: {
                type: Boolean,
                default: false
            },
        },
        mounted() {
            this.$nextTick(()=>{
                $(this.$el).find('a').click((e)=>{
                    if(this.redirectUrl) {
                        if(confirm(this.text)) {
                            window.location = this.redirectUrl;
                        } else {
                            return false;
                        }
                    } else if(this.reload) {
                        if(confirm(this.text)) {
                            window.location = window.location;
                        } else {
                            return false;
                        }
                    } else {
                        return confirm(this.text);
                    }
                });
            });
        },
        name: 'CustomConfirm'
    }
</script>
