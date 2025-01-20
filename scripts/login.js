let currentIndex = 0; // Current index for the slideshow
const images = document.querySelectorAll('.slide-show img'); // All slideshow images
const dots = document.querySelectorAll('.dot'); // All dots for the slideshow
const totalImages = images.length; // Total number of images

function showImage(index) {
    images.forEach((img, i) => {
        img.style.opacity = i === index ? 1 : 0; // Set opacity based on index
    });
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index); // Toggle active class on indicators
    });
}

setInterval(() => {
    currentIndex = (currentIndex + 1) % totalImages; // Update index
    showImage(currentIndex); // Show the next image
}, 10000); // Change image every 10 seconds

showImage(currentIndex); // Initialize the first image




document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password'); // Password input field
    const togglePassword = document.getElementById('togglePassword'); // Toggle password button

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password'; // Toggle type
        passwordInput.setAttribute('type', type); // Set new type

        // Toggle the eye / eye-slash icon
        togglePassword.innerHTML = type === 'password' 
            ? '<path fill="#8d8b97" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>' 
            : '<path fill="#8d8b97" d="M2 5.27L3.28 4L20 20.72L18.73 22l-3.08-3.08c-1.15.38-2.37.58-3.65.58c-5 0-9.27-3.11-11-7.5c.69-1.76 1.79-3.31 3.19-4.54zM12 9a3 3 0 0 1 3 3a3 3 0 0 1-.17 1L11 9.17A3 3 0 0 1 12 9m0-4.5c5 0 9.27 3.11 11 7.5a11.8 11.8 0 0 1-4 5.19l-1.42-1.43A9.86 9.86 0 0 0 20.82 12A9.82 9.82 0 0 0 12 6.5c-1.09 0-2.16.18-3.16.5L7.3 5.47c1.44-.62 3.03-.97 4.7-.97M3.18 12A9.82 9.82 0 0 0 12 17.5c.69 0 1.37-.07 2-.21L11.72 15A3.064 3.064 0 0 1 9 12.28L5.6 8.87c-.99.85-1.82 1.91-2.42 3.13"/>';
    });
});