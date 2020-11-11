<template>
    <a :class="className" @click.prevent="changeState" href="#">
        <div v-if="active">{{less}}</div>
        <div v-if="!active">{{more}}</div>
    </a>
</template>

<script>
    export default {
        props: {
            className: {
                type: String,
                default: ''
            },
            more: {
                type: String,
                default: 'Mehr'
            },
            less: {
                type: String,
                default: 'Weniger'
            },
            selector: {
                type: String,
                default: '#selector'
            },
            toggleClass: {
                type: String,
                default: ''
            },
            toggleAttr: {
                type: String,
                default: ''
            },
            unfolded: {
                type: Boolean,
                default: false
            },
        },
        methods: {
            changeState() {
                this.active = !this.active;
                if(this.active) {
                    if(this.toggleClass) {
                        $(this.selector).removeClass(this.toggleClass);
                    }
                } else {
                    if(this.toggleClass) {
                        $(this.selector).addClass(this.toggleClass);
                    }
                }

                if(this.toggleAttr) {
                    let bval = $(this.selector).attr(this.toggleAttr) === 'true' ? 'false' : 'true';
                    $(this.selector).attr(this.toggleAttr, bval);
                }
            }
        },
        mounted() {
            if(this.unfolded) {
                this.changeState();
            }
        },
        data() {
            return {
                active: false
            }
        },
        name: 'CustomTrigger'
    }
</script>

<style lang="scss">
    custom-trigger {
        display: block;
        div {
            font-weight: bold;
        }
    }
</style>
