<template>
    <div class="custom-upload" :class="{'custom-upload--singlefile': maxFiles == 1}">
        <input ref="file" style="display: none" type="file" @change="onFileChange" accept="image/*" multiple/>

        <div class="row">
            <div class="col-lg-6 col-sm-12 margin-inner-sm">
                <label class="custom-upload__label">{{label}}</label>
                <button class="btn btn--full" :disabled="nonDeletedFiles().length >= maxFiles" @click.prevent="selectFile">{{buttonText}}</button>
            </div>
            <div class="col-lg-6 col-sm-12">
                <label class="custom-upload__label">{{labelSelected}}</label>
                <transition-group>
                    <div key="files">
                        <input type="hidden" v-if="files.length" :name="name" :value="JSON.stringify(files)">
                        <div v-for="(file, index) in files" :key="index" class="custom-upload__file" v-if="!file.deleted || files.length <= 1 || maxFiles > 1" v-show="!file.deleted" :class="{'custom-upload__file--onefile': files.length === 1}">
                            <div class="custom-upload__file-name">
                                {{file.name}}
                            </div>
                            <div @click.prevent.stop="removeFile(file, index)" title="Datei löschen" class="custom-upload__delete"><i class="icon-times-circle"></i></div>
                        </div>
                    </div>
                </transition-group>
            </div>
        </div>
        <transition name="modal-fade">
            <div ref="modal" class="modal-backdrop" v-show="showEditor">
                <div class="modal"
                     role="dialog"
                     aria-labelledby="modalTitle"
                     aria-describedby="modalDescription"
                >
                    <div v-for="img in files" v-if="files.length && !img.deleted">
                        <header
                            class="modal-header"
                            id="modalTitle"
                        >
                            <h3 style="margin-bottom: 10px"><strong>Bild zuschneiden</strong></h3>
                            <p>
                                Positionieren Sie das Bild per Drag & Drop in den entsprechenden Ausschnitt. Mit dem Mausrad können Sie das Bild entsprechend Zoomen.
                            </p>
                            <div class="modal-body__actions">
                                <button class="btn" @click="crop(img)">Bild zuschneiden</button>
                            </div>
                        </header>
                        <section
                            class="modal-body"
                            id="modalDescription"
                        >
                            <div class="modal-body__image-container">
                                <img id="cropimg" v-crop :data-mime="img.mime" :data-ratio="initRatio" :src="img.dataUrl" alt="">
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import Cropper from 'cropperjs';
    import 'cropperjs/dist/cropper.css';

    let cropper = null;
    let cropperMime = null;

    export default {
        name: 'CustomUpload',
        props: {
            label: {
                default: 'Bild hinzufügen (max. 5)',
                type: String
            },
            labelSelected: {
                default: 'Ausgewählte Bilder',
                type: String
            },
            name: {
                default: 'file[data]',
                type: String
            },
            fileName: {
                default: 'file[name]',
                type: String
            },
            buttonText: {
                default: '+ Datei auswählen',
                type: String
            },
            maxFiles: {
                default: 5,
                type: [String, Number]
            },
            inputFiles: {
                default: '',
                type: String
            },
            maxFilesError: {
                default: 'Es können nur 5 Bilder hinterlegt werden!',
                type: String
            },
            editor: {
                default: true,
                type: Boolean
            },
            ratio: {
                default: 1.33333333333333,
                type: String
            },
        },
        data: function () {
            return {
                files: [],
                initRatio: 1,
                showEditor: false,
                cropper: null,
            };
        },
        watch:{
            files(val) {
                this.$emit('select', val);
            }
        },
        directives: {
            crop: {
                // directive definition

                inserted: function (el) {
                    cropperMime = el.getAttribute('data-mime');
                    let ratio = el.getAttribute('data-ratio');

                    if(cropper) {
                        cropper.destroy();
                        cropper = null;
                    }

                    cropper = new Cropper(el, {
                        dragMode: 'move',
                        viewMode: 0,
                        aspectRatio: ratio,
                        autoCropArea: 0.9,
                        restore: false,
                        guides: false,
                        center: false,
                        highlight: false,
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        toggleDragModeOnDblclick: false,
                    });
                }
            }
        },
        methods: {
            crop(img) {
                this.showEditor = false;
                img.dataUrl = cropper.getCroppedCanvas({
                    fillColor: '#fff',
                }).toDataURL(cropperMime);
            },
            nonDeletedFiles() {
                return this.files.filter(item => !item.deleted);
            },
            removeFile(file, index) {
                if(file.uploaded) {
                    file.deleted = true;
                } else {
                    this.files.splice(index, 1);
                }
                this.$forceUpdate();
            },
            selectFile(e) {
                this.$refs.file.click(e);
            },
            resizeImage(dataUrl, cb) {

                let img = document.createElement("img");
                img.onload = () => {

                    let canvas = document.createElement('canvas');

                    let ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);

                    let MAX_WIDTH = 1280;
                    let MAX_HEIGHT = 1280;
                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }
                    } else {
                        if (height > MAX_HEIGHT) {
                            width *= MAX_HEIGHT / height;
                            height = MAX_HEIGHT;
                        }
                    }
                    canvas.width = width;
                    canvas.height = height;
                    ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, width, height);
                    cb(canvas)
                };

                img.src = dataUrl;
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;

                if (!files.length)
                    return;

                if((files.length + this.nonDeletedFiles()) > parseInt(this.maxFiles)) {
                    alert(this.maxFilesError);
                    return;
                }

                for (let i = 0; i < files.length; i++) {
                    ((file) => {
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.resizeImage(e.target.result, (canvas)=>{
                                let mime = e.target.result.split(';')[0].replace('data:','') === 'image/png' ? 'image/png' : 'image/jpeg';

                                canvas.toBlob((blob) => {
                                    if(blob) {
                                        this.files.push({
                                            dataUrl: canvas.toDataURL(mime),
                                            mime: mime,
                                            size: blob.size,
                                            uploaded: false,
                                            deleted: false,
                                            name: file.name
                                        });
                                    }
                                }, mime, 0.90);
                            });
                        };
                        reader.readAsDataURL(file);
                    })(files[i]);
                }

                if(this.editor) {
                    this.showEditor = true;
                }

                this.$refs.file.value = '';
            }
        },
        mounted() {

            $('body').append(this.$refs.modal);
            this.initRatio = parseFloat(this.ratio);

            let obj = this.$el;

            obj.addEventListener('dragenter', (e) =>
            {
                e.stopPropagation();
                e.preventDefault();
            }, false);

            obj.addEventListener('dragover', (e) =>
            {
                e.stopPropagation();
                e.preventDefault();
            }, false);

            obj.addEventListener('drop', (e) =>
            {
                e.stopPropagation();
                e.preventDefault();

                this.onFileChange(e);
            }, false);

            this.files = this.inputFiles.toString().length ? JSON.parse(this.inputFiles) : [];
            this.files.forEach((item)=>{
                item.deleted = false;
                item.uploaded = true;
            });

            if (!HTMLCanvasElement.prototype.toBlob) {
                Object.defineProperty(HTMLCanvasElement.prototype, 'toBlob', {
                    value: function (callback, type, quality) {
                        let canvas = this;
                        setTimeout(function() {

                            let binStr = atob( canvas.toDataURL(type, quality).split(',')[1] ),
                                len = binStr.length,
                                arr = new Uint8Array(len);

                            for (let i = 0; i < len; i++ ) {
                                arr[i] = binStr.charCodeAt(i);
                            }

                            callback( new Blob( [arr], {type: type || 'image/png'} ) );
                        });
                    }
                });
            }
        },
    }
</script>

<style lang="scss">
    .custom-upload {
        margin-bottom: 15px;
    }
    .custom-upload__file {
        display: flex;
        flex-direction: row;
        padding: 15px 58px 14px 15px;
        background-color: #ccc;
        position: relative;
        margin-bottom: 1px;
        border: 1px solid transparent;
        cursor: move;
        > * {
            padding-right: 5px;
        }
        &.sortable-ghost {
            display: block;
            border: 1px dashed $color-yellow;
            height: 50px;
        }
        &.custom-upload__file--onefile {
            &:after {
                display: none;
            }
        }
    }

    .custom-upload__label {
        display: block;
        margin-bottom: 8px;
        @include font-size(16);
    }
    .custom-upload__file-name {
        position: relative;
        padding-left: 23px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        @include font-size(14);
        @include icon($icon-file-image-o, 'before', $color-black) {
            @include font-size(14);
            position: absolute;
            left: 0;
            top: 0;
        }
    }
    .custom-upload__delete {
        position: absolute;
        right: 4px;
        top: 13px;
        cursor: pointer;
    }
    .custom-upload--singlefile {
        .custom-upload__file:last-child:after {
            display: none;
        }
    }
    .modal-backdrop {
        position: fixed;
        top: 92px;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal {
        max-width: 1240px;
        max-height: calc(100% - 40px);
        margin: 20px 15px;
        background: #FFFFFF;
        box-shadow: 0px 1px 12px rgba(0, 0, 0, 0.3);
        overflow-x: auto;
        display: flex;
        flex-direction: column;
    }

    .modal-header,
    .modal-footer {
        padding: 15px;
        position: relative;
        .btn {
            padding: 8px 20px;
        }
    }

    .modal-header {
        justify-content: space-between;
        p {
            @include font-size(16);
        }
    }

    .modal-footer {
        justify-content: flex-end;
    }

    .modal-body {
        position: relative;
        padding: 20px 10px;
    }

    .modal-body__image-container {
        height: 100%;
        width: 100%;
    }

    .modal-body__actions {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        @include mq('sm') {
            position: relative;
            margin: 10px 10px 0;
        }
    }
</style>


