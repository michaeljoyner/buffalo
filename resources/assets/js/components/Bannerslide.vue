<style></style>

<template>
    <section class="slides-edit-view">
        <div class="banner-media-uploader">
            <label for="media-input">
                <img v-bind:class="{'uploading': progress > 0}" v-bind:src="media" alt="" v-show="!isVideo">
                <video v-bind:src="videoSrc" v-show="isVideo" autoplay muted loop></video>
                <input id="media-input" type="file" v-on:change="processFile">
            </label>
            <div class="progress-outer">
                <div class="progress-inner" v-bind:style="{ width: progress + '%'}"></div>
            </div>
            <p :class="{'dark': textColour === colours.black, 'brand': textColour === colours.brand}"
               class="banner-slide-text">{{ slideText }}</p>
            <a :class="textColour" class="banner-cta"
               v-show="actionText" href="{{ actionLink }}">{{ actionText }}</a>
        </div>
        <div class="dd-form form-horizontal">
            <div class="form-group">
                <label for="">Slide text:</label>
                <input type="text" v-model="slideText" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="">Action Button text:</label>
                        <input type="text" v-model="actionText" class="form-control" placeholder="Text for the button">
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-2">
                    <div class="form-group">
                        <label for="">Button links to:</label>
                        <select type="text" v-model="actionLink" class="form-control"
                                placeholder="where does the button link to">
                            <option v-for="option in linkOptions" :value="option.link">{{ option.name }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="colour-choices">
                        <label for="">Text color:</label>
                        <input type="radio" id="colour-1" v-model="textColour" :value="colours.white">
                        <label class="colour-label" for="colour-1">
                        </label>
                        <input type="radio" id="colour-2" v-model="textColour" :value="colours.brand">
                        <label class="colour-label" for="colour-2">
                        </label>
                        <input type="radio" id="colour-3" v-model="textColour" :value="colours.black">
                        <label class="colour-label" for="colour-3">
                        </label>
                    </div>
                </div>
                <div class="col-md-offset-2 col-md-5 publish-switch-box">
                    <label for="">Use slide on site?</label>
                    <toggle-switch identifier="1"
                                   true-label="yes"
                                   false-label="no"
                                   :initial-state="isPublished"
                                   :toggle-url="'/admin/slides/' + slideId + '/publishing'"
                                   toggle-attribute="publish"
                    ></toggle-switch>
                </div>
            </div>

            <div class="save-button">
                <button class="btn dd-btn" v-on:click="saveData" style="width: 10em;">
                    <span v-show="!saving">Save</span>
                    <div class="spinner" v-show="saving">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </button>
            </div>
        </div>
    </section>
</template>

<script type="text/babel">
    module.exports = {

        data() {
            return {
                saving: false,
                progress: 0,
                linkOptions: [
                    {name: 'Home - services', link: '/#services'},
                    {name: 'Home - products', link: '/#products'},
                    {name: 'Products page', link: '/products'},
                    {name: 'Contact Page', link: '/contact'},
                    {name: 'About page', link: '/about'}
                ],
                colours: {white: 'white', brand: 'brand', black: 'dark'},
                lastConfirmedSrc: null,
                lastConfirmedIsVideo: null,
                videoSrcIsObjectUrl: false,
                messages: {
                    invalid_file: 'That file is not an acceptable image or video type. Please use jpg or png for images and mp4 for video',
                    failed_upload: 'An error occurred while uploading. Reverting to previous state. Please try again later.',
                    failed_save: 'Sorry, we are unable to save your changes at the moment. Please refresh the page or try again later.'
                }
            }
        },

        props: ['media', 'video-src', 'slide-id', 'slide-text', 'action-text', 'action-link', 'text-colour', 'is-video', 'is-published'],

        ready() {
            this.lastConfirmedSrc = this.isVideo ? this.videoSrc : this.media;
            this.lastConfirmedIsVideo = this.isVideo;
        },

        methods: {
            processFile(ev) {
                let file = ev.target.files[0];
                if (file.type.indexOf('image') === -1 && file.type.indexOf('video') !== 0) {
                    this.sendAlert('Sorry, Invalid File Type', this.messages.invalid_file)
                    return;
                }
                this.handleFile(file);
            },

            handleFile(file) {
                if (file.type.indexOf('image') === 0) {
                    return this.handleImageFile(file);
                }

                this.handleVideo(file);
            },

            handleImageFile(file) {
                let fileReader = new FileReader();
                let uploaded = new Image;
                fileReader.onload = (ev) => {
                    uploaded.src = ev.target.result;
                    this.generatePreview(uploaded);
                }
                fileReader.readAsDataURL(file);
                this.uploadFile(file);
            },

            handleVideo(video) {
                this.setVideoSrc(video);
                this.isVideo = true;
                this.uploadFile(video);
            },

            setVideoSrc(video) {
                if (this.videoSrcIsObjectUrl) {
                    URL.revokeObjectURL(this.videoSrc);
                }
                this.videoSrc = URL.createObjectURL(video);
                this.videoSrcIsObjectUrl = true;
            },

            showVideo(vid) {
                this.isVideo = true;
                this.videoSrc = vid.src;
            },

            generatePreview(image) {
                this.drawPreview(image, this.getSourceDimensions(image.width, image.height, 2.3333));
                this.isVideo = false;
            },

            getSourceDimensions(iWidth, iHeight, ratio) {
                const isLandscape = iWidth / iHeight > ratio;

                return {
                    sWidth: isLandscape ? iHeight * ratio : iWidth,
                    sHeight: isLandscape ? iHeight : iWidth / ratio,
                    sX: isLandscape ? (iWidth - (iHeight * ratio)) / 2 : 0,
                    sY: isLandscape ? 0 : (iHeight - (iWidth / ratio)) / 2
                }
            },

            drawPreview(image, sDimensions) {
                let canvas = document.createElement('canvas');
                let ctx = canvas.getContext('2d');
                canvas.width = 1400;
                canvas.height = 600;
                ctx.drawImage(image, sDimensions.sX, sDimensions.sY, sDimensions.sWidth, sDimensions.sHeight, 0, 0, 1400, 600);
                this.media = canvas.toDataURL();
            },

            uploadFile(file) {
                this.$http.post('/admin/slides/' + this.slideId + '/media', this.prepareFormData(file), this.getUploadOptions())
                        .then((res) => this.onUploadSuccess())
                        .catch(() => this.onUploadFailure());
            },

            onUploadSuccess() {
                this.progress = 0;
                this.lastConfirmedIsVideo = this.isVideo;
                this.lastConfirmedSrc = this.isVideo ? this.videoSrc : this.media;
            },

            onUploadFailure() {
                this.sendAlert('Unable to upload', this.messages.failed_upload);
                this.progress = 0;
                this.revertToLastConfirmedState();
            },

            revertToLastConfirmedState() {
                if (this.lastConfirmedIsVideo) {
                    this.isVideo = true;
                    this.videoSrc = this.lastConfirmedSrc;
                    return;
                }

                this.isVideo = false;
                this.media = this.lastConfirmedSrc;
            },

            prepareFormData: function (file) {
                let fd = new FormData();
                fd.append('file', file);
                return fd;
            },

            getUploadOptions() {
                return {
                    progress: (ev) => this.progress = parseInt(ev.loaded / ev.total * 100)
                }
            },

            saveData() {
                this.saving = true;
                this.$http.post('/admin/api/slides/' + this.slideId, {
                    'slide_text': this.slideText,
                    'action_text': this.actionText,
                    'action_link': this.actionLink,
                    'text_colour': this.textColour
                }).then((res) => this.saving = false)
                        .catch(() => this.failedToSave());
            },

            failedToSave() {
                this.sendAlert('Unable to Save', this.messages.failed_save)
                this.saving = false;
            },

            sendAlert(title, message) {
                this.$dispatch('user-alert', {
                    title: title,
                    text: message,
                    confirm: true,
                    type: 'error'
                });
            }
        }
    }
</script>