document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) event.preventDefault();
    });
});

document.querySelector('.flash-close')?.addEventListener('click', (event) => {
    event.currentTarget.closest('.flash-message')?.remove();
});

const imageInput = document.querySelector('#image_url');
const imagePreview = document.querySelector('[data-image-preview]');
if (imageInput && imagePreview) {
    imageInput.addEventListener('input', () => {
        const url = imageInput.value.trim();
        let image = imagePreview.querySelector('img');
        if (!image) {
            imagePreview.replaceChildren();
            image = document.createElement('img');
            image.alt = 'Pratinjau gambar produk';
            imagePreview.append(image);
        }
        image.src = url;
        image.hidden = !url;
    });
}

document.querySelectorAll('.product-image, .image-preview img').forEach((image) => {
    image.addEventListener('error', () => {
        image.closest('.product-image-wrap, .image-preview')?.classList.add('image-unavailable');
        image.hidden = true;
    }, { once: true });
});
