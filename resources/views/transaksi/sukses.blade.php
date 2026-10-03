<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Cek apakah izin notifikasi sudah diberikan
        if ("Notification" in window && Notification.permission === "granted") {
            
            // Tunggu Service Worker siap
            navigator.serviceWorker.ready.then(function (registration) {
                // Tampilkan notifikasi push langsung ke layar HP / Layar Kunci
                registration.showNotification("Kopkar RSPB - Transaksi Berhasil! 🛒", {
                    body: "Terima kasih! Belanjaan Anda sebesar Rp 150.000 telah berhasil diproses.",
                    icon: "/images/koperasi.png",
                    badge: "/images/koperasi.png",
                    vibrate: [200, 100, 200], // Getaran HP
                    tag: "transaksi-sukses",
                    data: {
                        url: "/transaksi" // URL yang dibuka saat notifikasi di-klik di layar kunci
                    }
                });
            });

        }
    });
</script>