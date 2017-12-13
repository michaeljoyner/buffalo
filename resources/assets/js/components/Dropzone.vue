<style>

</style>

<template>
    <div class="drop-area"
         @drop.prevent="handleFiles"
         @dragenter.prevent="hover=true"
         @dragover.prevent="hover=true"
         @dragleave="hover=false"
         :class="{'hovering': hover}">
        <label for="dropzone-input">
            <p class="drag-prompt" v-show="uploads.length === 0">Drag files or click to upload!</p>
            <input @change.stop.prevent="handleFiles" type="file" id="dropzone-input" multiple style="display:none;"/>
            <ul>
                <li v-for="upload in uploads" v-show="upload.status !== 'success'">
                    <p
                            class="image-upload-info"
                            :class="{'failed': upload.status === 'failed'}"
                    >
                        <span class="upload-progress-bar"
                              :style="{width: upload.progress + '%'}"></span>
                        {{ upload.name }}
                    </p>
                </li>
            </ul>
        </label>
    </div>
</template>

<script type="text/babel">
    let Upload = require('./Upload.js');
    module.exports = {

        props: ['url'],

        data() {
            return {
                uploads: [],
                hover: false
            }
        },

        methods: {

            handleFiles(ev) {
                var files = ev.target.files || ev.dataTransfer.files;
                for (var i = 0; i < files.length; i++) {
                    this.processFile(files[i]);
                }
            },

            processFile(file) {
                var upload = new Upload(file.name, 'pending');
                axios.post(this.url, this.makeFormData(file), this.makeUploadOptions(upload))
                        .then(({data}) => {
                            upload.setStatus('success');
                            this.removeUpload(upload);
                            this.alertParent(data);
                        })
                        .catch(() => upload.setStatus('failed'));
                this.uploads.push(upload);
            },

            makeFormData(file) {
                let fd = new FormData();
                fd.append('file', file);
                return fd;
            },

            makeUploadOptions(upload) {
                return {
                    progress: (ev) => upload.setProgress(parseInt(ev.loaded / ev.total * 100))
                }
            },

            alertParent: function (image) {
                eventHub.$emit('dz-image-added', image);
            },

            removeUpload(upload) {
                this.uploads.splice(this.uploads.indexOf(upload), 1);
            }


        }
    }
</script>