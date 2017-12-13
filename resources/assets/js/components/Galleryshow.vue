<style>

</style>

<template>
    <div class="gallery-container">
        <p class="empty-gallery-note" v-show="images.length === 0">There are currently no images in this gallery</p>
        <div class="gallery-item"
             v-for="image in images" :key="image.id"
        >
            <div @click="removeImage(image)" class="gallery-item-delete-btn">&times;</div>
            <img :src="image.thumb_src" alt="gallery image"/>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props:['geturl', 'gallery', 'delete-url'],

        data: function() {
            return {
                images: []
            }
        },

        mounted() {
            this.fetchImages();

            eventHub.$on('dz-image-added', (image) => this.addImage(image));
        },

        methods: {

            fetchImages() {
                axios.get(this.geturl)
                        .then(({data}) =>  this.images = data)
                        .catch((res) => console.log(res));
            },

            addImage(image) {
                this.images.push(image);
            },

            removeImageFromGallery(image) {
                this.images.splice(this.images.indexOf(image), 1);
            },

            removeImage(image) {
                axios.delete(this.deleteUrl + image.image_id)
                        .then(() => this.removeImageFromGallery(image))
                        .catch(() => eventHub.$emit('error-alert', "Something failed on the server and the image could not be deleted. Please try again later or ask for help"));
            }
        }
    }
</script>