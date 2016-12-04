<script>
    var UploadProgressMeter = {
        uploads: [],

        tags: [],

        showProgress: function (progress, tag) {
            console.log(tag + ' : ' + progress);
        },

        getNextTag: function () {
            var nextTag = 'tag' + (UploadProgressMeter.tags.length + 1);
            UploadProgressMeter.tags.push(nextTag);
            UploadProgressMeter.uploads.push(nextTag);
            return nextTag;
        },

        markTagAsComplete: function(tag) {
            UploadProgressMeter.uploads = UploadProgressMeter.uploads.splice(UploadProgressMeter.uploads.indexOf(tag) + 1, 1);
            console.log(UploadProgressMeter.uploads);
        }
    };

    var uploadHandler = {
        elems: {
            file: document.querySelector('#post-file-input')
        },

        init: function () {
            uploadHandler.elems.file.addEventListener('change', uploadHandler.processFile, false);
        },

        processFile: function (ev) {
            var fileReader = new FileReader();
            fileReader.onload = function (ev) {
                tinymce.activeEditor.insertContent("<img src=" + ev.target.result + ">");
            }
            fileReader.readAsDataURL(ev.target.files[0]);
        }
    }
    uploadHandler.init();

    var submitHandler = {
        init: function() {
            var form = document.querySelector('#blog-editor-form');
            form.addEventListener('submit', submitHandler.handleSubmit, false);
        },

        handleSubmit: function(ev) {
            if(UploadProgressMeter.uploads.length) {
                ev.preventDefault();
                swal({
                    title: "Wait just a second!",
                    text: "Your images are still uploading, try again in a few seconds.",
                    type: "error",
                    confirmButtonText: "Got it"
                });

                return false;
            }

            if(document.querySelector('#post-description').value.trim() === '') {
                ev.preventDefault();
                swal({
                    title: "Wait just a second!",
                    text: "You need to have some sort of description. It is important",
                    type: "error",
                    confirmButtonText: "Got it"
                });

                return false;
            }

        }
    };
    submitHandler.init();
</script>
<script>
    tinymce.init({
        selector: '#post-body',
        plugins: ['link', 'image', 'paste', 'fullscreen'],
        menubar: false,
        toolbar: 'undo redo | styleselect | bold italic | bullist numlist | link mybutton | fullscreen save_button',
        paste_data_images: true,
        height: 700,
        body_class: 'article-body-content',
//            content_css: '/css/editor.css',
        content_style: "body {font-size: 16px; max-width: 800px; margin: 0 auto;} * {font-size: 16px;} img {opacity: .6; max-width: 100%; height: auto;} img[data-mce-src] {opacity: 1;}",
        setup: function (ed) {
            ed.addButton('mybutton', {
                text: '',
                icon: true,
                image: '/images/assets/insert_photo_black.png',
                onclick: function () {
                    document.querySelector('#post-file-input').click();
                }
            });
            ed.addButton('save_button', {
                text: '',
                icon: true,
                image: '/images/assets/save_button_icon.png',
                onclick: function () {
                    document.querySelector('#blog-editor-form-submit').click();
                }
            });
        },
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            var uploadTag = UploadProgressMeter.getNextTag();

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/admin/blog/posts/{{ $post->id }}/images');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.upload.addEventListener('progress', function (ev) {
                UploadProgressMeter.showProgress(parseInt(ev.loaded / ev.total * 100), uploadTag);
            });

            xhr.onload = function () {
                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
                UploadProgressMeter.markTagAsComplete(uploadTag);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('_token', document.getElementById('x-token').getAttribute('content'));


            xhr.send(formData);
        }
    });
</script>
