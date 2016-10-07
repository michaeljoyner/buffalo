<style>

</style>

<template>
    <label for="profile-upload" class="single-upload-label">
        <img :src="imageSrc" alt="" class="profile-image"
             v-bind:class="{'processing' : uploading, 'large': size === 'large', 'round': shape === 'round', 'full': size === 'full' }"/>
        <input v-on:change="processFile" type="file" id="profile-upload"/>
    </label>
    <div class="upload-progress-container" v-show="uploading">
        <span class="upload-progress-bar"
              v-bind:style="{width: uploadPercentage + '%'}"></span>
    </div>
    <p class="upload-message"
       v-bind:class="{'error': uploadStatus === 'error', 'success': uploadStatus === 'success'}"
       v-show="uploadMsg !== ''">{{ uploadMsg }}
    </p>
</template>

<script type="text/babel">
    module.exports = {
        props: ['default', 'url', 'shape', 'size'],

        data() {
            return {
                imageSource: '',
                uploadMsg: '',
                uploading: false,
                uploadStatus: '',
                uploadPercentage: 0
            }
        },

        computed: {
            imageSrc() {
                return this.imageSource ? this.imageSource : this.default;
            }
        },

        methods: {
            processFile(ev) {
                var file = ev.target.files[0];
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
                var fileReader = new FileReader();
                var self = this;
                fileReader.onload = function (ev) {
                    self.uploading = true;
                    self.imageSource = ev.target.result;
                }
                fileReader.readAsDataURL(file);
                this.uploadFile(file);
            },


            uploadFile(file) {
                this.$http.post(this.url, this.prepareFormData(file), this.getUploadOptions())
                        .then(res => this.onUploadSuccess(res))
                        .catch(err => this.onUploadFailed(err));
            },

            prepareFormData: function (file) {
                let fd = new FormData();
                fd.append('file', file);
                return fd;
            },

            onUploadSuccess(res) {
                this.uploadMsg = "Uploaded successfully";
                this.uploadStatus = 'success'
                this.uploading = false;
                this.$dispatch('singleuploadcomplete', res.json());
            },

            onUploadFailed(err) {
                this.uploadMsg = 'The upload failed';
                this.uploadStatus = 'error';
                console.log(err);
            },

            getUploadOptions() {
                return {
                    progress: (ev) => this.showProgress(parseInt(ev.loaded / ev.total * 100))
                }
            },

            showProgress(progress) {
                console.log(progress + '% complete!');
                this.uploadPercentage = progress;
            },

            clearMessage() {
                this.uploadMsg = ''
            },

            setImage(src) {
                this.imageSource = src;
            }
        }

    }
</script>