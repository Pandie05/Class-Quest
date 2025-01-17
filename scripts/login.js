let currentIndex = 0;
const images = document.querySelectorAll('.slide-show img');
const dots = document.querySelectorAll('.dot');
const totalImages = images.length;

function showImage(index) {
    images.forEach((img, i) => {
        img.style.opacity = i === index ? 1 : 0;
    });
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
}

setInterval(() => {
    currentIndex = (currentIndex + 1) % totalImages;
    showImage(currentIndex);
}, 10000); // Change image every 10 seconds

showImage(currentIndex); // Initialize the first image
