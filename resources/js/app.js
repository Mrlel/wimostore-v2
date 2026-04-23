import './bootstrap';

if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
        navigator.serviceWorker
            .register("/service-worker.js")
            .then((reg) => console.log("✅ Service Worker enregistré:", reg))
            .catch((err) => console.log("❌ Erreur Service Worker:", err));
    });
}
