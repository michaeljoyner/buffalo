<style>

</style>

<template>
    <div class="drop-area"
         v-on:drop.prevent="handleFiles"
         v-on:dragenter.prevent="hover=true"
         v-on:dragover.prevent="hover=true"
         v-on:dragleave="hover=false"
         v-bind:class="{'hovering': hover}">
        <label for="dropzone-input">
            <p class="drag-prompt" v-show="uploads.length === 0">Drag files or click to upload!</p>
            <input v-on:change.stop.prevent="handleFiles" type="file" id="dropzone-input" multiple style="display:none;"/>
            <ul>
                <li v-for="upload in uploads" v-show="upload.status !== 'success'">
                    <p
                            class="image-upload-info"
                            v-bind:class="{'failed': upload.status === 'failed'}"
                    >
                        <span class="upload-progress-bar"
                              v-bind:style="{width: upload.progress + '%'}"></span>
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
                this.$http.post(this.url, this.makeFormData(file), this.makeUploadOptions(upload))
                        .then((res) => {
                            upload.setStatus('success');
                            this.uploads.$remove(upload);
                            this.alertParent(res.data);
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
                this.$dispatch('image-added', image);
            }


        }
    }
</script>