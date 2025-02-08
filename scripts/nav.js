const hamburger = document.querySelector(".hamburger");
const iconLinks = document.querySelector(".icon-links");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    iconLinks.classList.toggle("active");
});

// Close menu when clicking a link
document.querySelectorAll(".icon-links a").forEach(n => n.addEventListener("click", () => {
    hamburger.classList.remove("active");
    iconLinks.classList.remove("active");
}));