<style></style>

<template>
    <section class="slides-edit-view">
        <div class="banner-media-uploader">
            <div class="instruction-box">
                <p>Click here to upload an image or video.</p>
                <p>For best results, use an image of at least 1400 x 467px and with that aspect ratio of 3:1</p>
                <p>Video should ideally be cropped at 1400 x 840 and have a small as possible file size.</p>
            </div>
            <label for="media-input">
                <img :class="{'uploading': progress > 0}" :src="media" alt="" v-show="!isVideo">
                <video :src="videoSrc" v-show="isVideo" autoplay muted loop></video>
                <input id="media-input" type="file" @change="processFile">
            </label>
            <div class="progress-outer">
                <div class="progress-inner" :style="{ width: progress + '%'}"></div>
            </div>
            <p :class="{'dark': text_colour === colours.black, 'brand': text_colour === colours.brand}"
               class="banner-slide-text">{{ slide_text }}</p>
            <a :class="text_colour" class="banner-cta"
               v-show="action_text" :href="actionLink">{{ action_text }}</a>
        </div>
        <div class="dd-form form-horizontal">
            <div class="form-group">
                <label for="">Slide text:</label>
                <input type="text" v-model="slide_text" class="form-control" placeholder="Text to be shown on slide">
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="">Action Button text:</label>
                        <input type="text" v-model="action_text" class="form-control" placeholder="Text for the button">
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-2">
                    <div class="form-group">
                        <label for="">Button links to:</label>
                        <select type="text" v-model="action_link" class="form-control"
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
                        <input type="radio" id="colour-1" v-model="text_colour" :value="colours.white">
                        <label class="colour-label" for="colour-1">
                        </label>
                        <input type="radio" id="colour-2" v-model="text_colour" :value="colours.brand">
                        <label class="colour-label" for="colour-2">
                        </label>
                        <input type="radio" id="colour-3" v-model="text_colour" :value="colours.black">
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
                <button class="btn dd-btn" @click="saveData" style="width: 10em;">
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
    export default {

        data() {
            return {
                max_file_size_mb: 15,
                saving: false,
                progress: 0,
                linkOptions: [],
                colours: {white: 'white', brand: 'brand', black: 'dark'},
                lastConfirmedSrc: this.isVideo ? this.videoSrc : this.media,
                lastConfirmedIsVideo: this.isVideo,
                videoSrcIsObjectUrl: false,
                text_colour: this.textColour,
                slide_text: this.slideText,
                action_text: this.actionText,
                action_link: this.actionLink,
                messages: {
                    invalid_file: 'That file is not an acceptable image or video type. Please use jpg or png for images and mp4 for video',
                    failed_upload: 'An error occurred while uploading. Reverting to previous state. Please try again later.',
                    failed_save: 'Sorry, we are unable to save your changes at the moment. Please refresh the page or try again later.'
                }
            }
        },

        props: ['media', 'video-src', 'slide-id', 'slide-text', 'action-text', 'action-link', 'text-colour', 'is-video', 'is-published'],

        mounted() {
            this.fetchLinks();
        },

        computed: {
            maxFileSizeMessage() {
                return `Large file sizes for videos will load very slowly. Please use files lower than ${this.max_file_size_mb}MB`;
            }
        },

        methods: {

            fetchLinks() {
                axios.get('/admin/sitelinks')
                        .then(({data}) => this.setLinkOptions(data))
                        .catch(() => this.sendAlert('Unable to get links', 'There was a problem, sorry. Please refresh and try again.'))
            },

            setLinkOptions(links) {
                Object.keys(links).forEach((key) => this.linkOptions.push({name: key, link: links[key]}));
            },

            processFile(ev) {
                let file = ev.target.files[0];
                if (file.type.indexOf('image') === -1 && file.type.indexOf('video') !== 0) {
                    this.sendAlert('Sorry, Invalid File Type', this.messages.invalid_file);
                    return;
                }
                if (file.size > (1024 * 1000 * this.max_file_size_mb)) {
                    this.sendAlert('Sorry, That file is just too big.', this.maxFileSizeMessage);
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
                    uploaded.onload = (ev) => this.generatePreview(ev.target);
                };
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
                this.drawPreview(image, this.getSourceDimensions(image.width, image.height, 3));
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
                canvas.height = 467;
                ctx.drawImage(image, sDimensions.sX, sDimensions.sY, sDimensions.sWidth, sDimensions.sHeight, 0, 0, 1400, 467);
                let newSrc = canvas.toDataURL();
                this.media = newSrc;
            },

            uploadFile(file) {
                axios.post(`/admin/slides/${this.slideId}/media`, this.prepareFormData(file), this.getUploadOptions())
                        .then(({data}) => this.onUploadSuccess())
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
                axios.post(`/admin/api/slides/${this.slideId}`, {
                    'slide_text': this.slide_text,
                    'action_text': this.action_text,
                    'action_link': this.action_link,
                    'text_colour': this.text_colour
                }).then(({data}) => this.saving = false)
                        .catch(() => this.failedToSave());
            },

            failedToSave() {
                this.sendAlert('Unable to Save', this.messages.failed_save);
                this.saving = false;
            },

            sendAlert(title, message) {
                eventHub.$emit('error-alert', message);
            }
        }
    }
</script>