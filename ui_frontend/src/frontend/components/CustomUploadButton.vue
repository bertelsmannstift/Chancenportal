<template>
    <div class="upload-button">
        <button @click.prevent="selectFile" type="button" class="btn btn--primary" :disabled="disabled"><slot></slot></button>
        <input type="file" ref="file" @change="onFileChange" :accept="accept" :name="name"/>
    </div>
</template>

<script>
    export default {
        name: 'CustomUploadButton',
        props: {
            submit: {
                default: false,
                type: Boolean
            },
            name: {
                default: 'file',
                type: String
            },
            accept: {
                default: '*/*',
                type: String
            },
        },
        data() {
            return {
                disabled: false
            }
        },
        methods: {
            selectFile() {
                this.$refs.file.click();
            },
            onFileChange(e) {
                if(this.submit) {
                    this.disabled = true;
                    this.$refs.file.form.submit();
                }
            }
        }
    }
</script>

<style lang="scss">

    .upload-button {
        display: block;
        [type="file"] {
            display: none;
        }
        .btn {
            width: 100%;
        }
    }
</style>
