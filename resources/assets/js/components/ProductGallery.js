const productGallery = {
    els: {
        container: null,
        imgs: null,
        links: null,
        canvas: null,
        currentSrc: null,
    },

    init: function () {
        productGallery.els.container = document.querySelector('.product-gallery');
        productGallery.els.links = Array.prototype.slice.call(document.querySelectorAll('.product-gallery-nav a'));
        productGallery.els.imgs = Array.prototype.slice.call(document.querySelectorAll('.product-gallery img'));
        productGallery.els.canvas = document.querySelector('.mag-canvas');
        productGallery.els.currentImage = productGallery.setImageFromSrc(document.querySelector('.product-gallery img.show'));

        productGallery.setListeners();
    },

    setImageFromSrc: function (original) {
        var img = new Image();
        img.src = original.src;
        return img;
    },

    setListeners: function () {
        productGallery.els.links.forEach(function (link) {
            link.addEventListener('click', productGallery.setImage, false);
        });

        productGallery.els.container.addEventListener('mouseenter', productGallery.showMagnifier, false);
        productGallery.els.container.addEventListener('mousemove', productGallery.positionMagnifier, false);
        productGallery.els.container.addEventListener('mouseleave', productGallery.hideMagnifier, false);
    },

    showMagnifier: function () {
        console.log('moused');
        productGallery.els.canvas.style.display = "block";
    },

    positionMagnifier: function (ev) {
        var canvas = productGallery.els.canvas;
        var ctx = canvas.getContext('2d');
        var source = productGallery.els.currentImage;
        canvas.height = canvas.width / (source.width / source.height);
        var wholeXSpace = source.width - canvas.width;
        var wholeYSpace = source.height - canvas.height;
        var sourceXPos = Math.min(((ev.offsetX / canvas.width) * wholeXSpace), (source.width - canvas.width));
        var sourceYPos = Math.min(((ev.offsetY / canvas.height) * wholeYSpace), (source.height - canvas.height));

        ctx.drawImage(productGallery.els.currentImage, sourceXPos, sourceYPos, canvas.width, canvas.height, 0, 0, canvas.width, canvas.height);
    },

    hideMagnifier: function () {
        productGallery.els.canvas.style.display = "none";
    },


    setImage: function (ev) {
        ev.preventDefault();
        ev.stopPropagation();
        var targetImage = ev.target.getAttribute('data-image');
        if (ev.target.tagName === 'IMG') {
            targetImage = ev.target.parentNode.getAttribute('data-image');
        }

        productGallery.els.imgs.forEach(function (img) {
            if (img.id === targetImage) {
                img.classList.add('show');
            } else {
                img.classList.remove('show');
            }
        });

        productGallery.els.currentImage = productGallery.setImageFromSrc(document.querySelector('.product-gallery img.show'));
    }
};

export {productGallery};