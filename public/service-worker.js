self.addEventListener('install', (e) => {
    console.log('[Service Worker] Installed');
    self.skipWaiting();
});

self.addEventListener('activate', (e) => {
    return self.clients.claim();
});

self.addEventListener('fetch', (e) => {
    // Handling fetch/caching jika diperlukan
});

// TERIMA PUSH NOTIFICATION
self.addEventListener('push', function(event) {
    let data = {};
    if (event.data) {
        try {
            data = event.data.json();
        } catch (err) {
            data = { body: event.data.text() };
        }
    }

    const title = data.title || "Notifikasi Koperasi";
    const options = {
        body: data.body || "Ada pembaruan akun Anda.",
        icon: "/images/koperasi.png",
        badge: "/images/koperasi.png",
        vibrate: [100, 50, 100],
        data: {
            url: data.url || '/' // Halaman yang dituju saat diklik
        }
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

// BUKA APP SAAT NOTIFIKASI DIKLIK
self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    
    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});