<style>

</style>

<template>
    <div class="gallery-container">
        <p class="empty-gallery-note" v-show="images.length === 0">There are currently no images in this gallery</p>
        <div class="gallery-item"
             v-for="image in images"
        >
            <div v-on:click="removeImage(image)" class="gallery-item-delete-btn">&times;</div>
            <img v-bind:src="image.thumb_src" alt="gallery image"/>
        </div>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props:['geturl', 'gallery', 'delete-url'],

        data: function() {
            return {
                images: []
            }
        },

        ready: function() {

            this.fetchImages();

            this.$on('add-image', function(image) {
                this.addImage(image);
            });
        },

        methods: {

            fetchImages() {
                this.$http.get(this.geturl)
                        .then((res) =>  this.$set('images', res.data))
                        .catch((res) => console.log(res));
            },

            addImage(image) {
                this.images.push(image);
            },

            removeImage(image) {
                this.$http.delete(this.deleteUrl + image.image_id)
                        .then(() => this.images.$remove(image))
                        .catch(() => {
                            swal({
                                type: "error",
                                title: "Oops! An error occured",
                                text: "Something failed on the server and the image could not be deleted. Please try again later or ask for help",
                                showConfirmButton: true
                            });
                        });
            }
        }
    }
</script>