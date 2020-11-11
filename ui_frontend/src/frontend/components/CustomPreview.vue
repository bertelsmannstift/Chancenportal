<template>
    <span class="custom-preview">
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
        },
        mounted() {
            $(this.$el).find('a, button').click(function(e) {
                $(this).parents('form').attr('target', '_blank');
                setTimeout(()=>{
                    $(this).parents('form').removeAttr('target');
                }, 500);
            });
        },
        name: 'CustomPreview'
    }
</script>
