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

// Global loading overlay handler
class LoadingManager {
    constructor() {
        this.overlay = document.getElementById('loading-overlay');
        this.isProcessing = false;
        this.setupUnloadHandler();
    }

    setupUnloadHandler() {
        window.addEventListener('beforeunload', () => this.show());
    }

    show() {
        if (this.overlay) {
            this.overlay.style.display = 'flex';
        }
    }

    hide() {
        if (this.overlay) {
            this.overlay.style.display = 'none';
        }
    }

    async wrapPromise(promise) {
        if (this.isProcessing) return;
        this.isProcessing = true;
        this.show();

        try {
            const result = await promise;
            return result;
        } finally {
            this.hide();
            this.isProcessing = false;
        }
    }
}

// Initialize the loading manager
const loadingManager = new LoadingManager();

// Export for use in other files
window.loadingManager = loadingManager;