<template>
    <div class="inner-box">
        <label :for="`profile-upload-${unique}`"
               class="single-upload-label">
            <img :src="imageSrc"
                 alt=""
                 class="profile-image"
                 :style="{width: prevWidth, height: prevHeight}"
                 :class="{'processing' : uploading, 'large': size === 'large', 'round': shape === 'round', 'full': size === 'full' }"/>
            <input @change="processFile"
                   type="file"
                   :id="`profile-upload-${unique}`"/>
        </label>
        <div class="upload-progress-container"
             v-show="uploading">
        <span class="upload-progress-bar"
              :style="{width: uploadPercentage + '%'}"></span>
        </div>
        <button v-show="removeUrl"
             @click="clearImage"
             class="clear-image btn btn-red">Clear Image
        </button>
        <p class="upload-message"
           :class="{'error': uploadStatus === 'error', 'success': uploadStatus === 'success'}"
           v-show="uploadMsg !== ''">{{ uploadMsg }}
        </p>
    </div>

</template>

<script type="text/babel">

    import {generatePreview} from './PreviewGenerator.js';

    export default {

        props: {
            default: null,
            url: String,
            shape: {type: String, default: 'square'},
            size: {type: String, default: 'large'},
            previewWidth: {type: Number, default: 300},
            previewHeight: {type: Number, default: 300},
            unique: {type: Number, default: 1},
            'delete-url': {type: String, default: null}
        },

        data() {
            return {
                imageSource: '',
                uploadMsg: '',
                uploading: false,
                uploadStatus: '',
                uploadPercentage: 0,
                removeImageUrl: null,
                hasRemoved: false
            }
        },

        computed: {

            imageSrc() {
                return this.imageSource ? this.imageSource : this.default;
            },

            removeUrl() {
                if (!this.hasRemoved) {
                    return this.removeImageUrl ? this.removeImageUrl : this.deleteUrl;
                }
            },

            prevWidth() {
                if (this.size === 'preview') {
                    return this.previewWidth + 'px';
                }
                if (this.size === 'large') {
                    return '300px';
                }
                return '200px';
            },

            prevHeight() {
                if (this.size === 'preview') {
                    return 'auto';
                }
                if (this.size === 'large') {
                    return '300px';
                }
                return '200px';
            }
        },

        methods: {

            processFile(ev) {
                const file = ev.target.files[0];
                this.clearMessage();
                if (file.type.indexOf('image') === -1) {
                    this.showInvalidFile(file.name);
                    return;
                }
                this.handleFile(file);
            },

            showInvalidFile(name) {
                this.uploadMsg = name + ' is not a valid image file';
                this.uploadStatus = 'error';
            },

            handleFile(file) {
                generatePreview(file, {pWidth: this.previewWidth, pHeight: this.previewHeight})
                    .then((src) => this.imageSource = src)
                    .catch((err) => console.log(err));
                this.uploadFile(file);
            },

            uploadFile(file) {
                this.uploading = true;
                axios.post(this.url, this.prepareFormData(file), this.getUploadOptions())
                    .then(({data}) => this.onUploadSuccess(data))
                    .catch(err => this.onUploadFailed(err));
            },

            prepareFormData: function (file) {
                let fd = new FormData();
                fd.append('file', file);
                return fd;
            },

            onUploadSuccess(data) {
                this.uploadMsg = "Uploaded successfully";
                this.uploadStatus = 'success';
                this.uploading = false;
                this.hasRemoved = false;
                this.$emit('singleuploadcomplete', data);
                this.removeImageUrl = data.delete_url || null;
                window.setTimeout(() => this.clearMessage(), 2000);
            },

            onUploadFailed(err) {
                this.uploadMsg = 'The upload failed';
                this.uploadStatus = 'error';
            },

            getUploadOptions() {
                return {
                    progress: (ev) => this.showProgress(parseInt(ev.loaded / ev.total * 100))
                }
            },

            showProgress(progress) {
                this.uploadPercentage = progress;
            },

            clearMessage() {
                this.uploadMsg = ''
            },

            clearImage() {
                axios.delete(this.removeUrl)
                    .then(() => this.onRemoveSuccess())
                    .catch(err => console.log(err));
            },

            onRemoveSuccess() {
                this.imageSource = '/images/defaults/default4x3.jpg';
                this.removeImageUrl = null;
                this.hasRemoved = true;
            },

            setImage(src) {
                this.imageSource = src;
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

    .inner-box {
        position: relative;
    }

    .profile-image {
        width: 200px;
        height: 200px;
        margin: 0 auto;
        display: block;
        border: 1px solid dodgerblue;
        max-width: 100%;

        &.processing {
            filter: grayscale(100%);
        }

        &.large {
            width: 300px;
            height: 300px;
        }

        &.full {
            width: 100%;
            height: auto;
            min-height: 200px;
        }

        &.round {
            border-radius: 50%;
        }
    }

    .single-upload-label {
        display: block;
    }

    input[type=file] {
        display: none;
        width: 100%;
    }

    .upload-message {
        color: #333;
        background: lighten(dodgerblue, 20%);
        padding: 4px 8px;
        border-radius: 5px;
        display: block;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        text-align: center;

        &.error {
            color: white;
            background: indianred;
        }
    }

    .upload-progress-container {
        width: 100%;
        max-width: 250px;
        height: 16px;
        border: 1px solid dodgerblue;
        position: relative;
        display: block;
        margin: 0 auto;

        .upload-progress-bar {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            background: dodgerblue;
        }


    }
    .clear-image.btn.btn-red {
        transform-origin: center bottom;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%) scale(.7);
    }
</style>