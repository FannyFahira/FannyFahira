// Fungsi untuk mengecek apakah cookies sudah disetujui
function checkCookieConsent() {
    return localStorage.getItem('cookieConsent') === 'true';
}

// Fungsi untuk menampilkan notifikasi cookies
function showCookieNotification() {
    if (!checkCookieConsent()) {
        // Buat container untuk notifikasi cookies
        const cookieContainer = document.createElement('div');
        cookieContainer.id = 'cookie-notification';
        cookieContainer.className = 'cookie-notification';
        
        // Isi notifikasi
        cookieContainer.innerHTML = `
            <div class="cookie-content">
                <div class="cookie-text">
                    <h3>Kami Menggunakan Cookies</h3>
                    <p>Website ini menggunakan cookies untuk meningkatkan pengalaman Anda. Dengan melanjutkan, Anda menyetujui penggunaan cookies sesuai kebijakan kami.</p>
                </div>
                <div class="cookie-buttons">
                    <button id="accept-cookies" class="cookie-btn accept">Setuju</button>
                    <button id="reject-cookies" class="cookie-btn reject">Tolak</button>
                    <a href="/kebijakan-privasi" class="cookie-policy">Kebijakan Privasi</a>
                </div>
            </div>
        `;
        
        // Tambahkan ke body (bukan di dalam footer)
        document.body.appendChild(cookieContainer);
        
        // Event listener untuk tombol setuju
        document.getElementById('accept-cookies').addEventListener('click', function() {
            acceptCookies();
        });
        
        // Event listener untuk tombol tolak
        document.getElementById('reject-cookies').addEventListener('click', function() {
            rejectCookies();
        });
    }
}

// Fungsi ketika user menekan tombol setuju
function acceptCookies() {
    localStorage.setItem('cookieConsent', 'true');
    hideCookieNotification();
    // Aktifkan cookies dan tracking jika diperlukan
    // ...
}

// Fungsi ketika user menekan tombol tolak
function rejectCookies() {
    localStorage.setItem('cookieConsent', 'false');
    hideCookieNotification();
    // Nonaktifkan cookies dan tracking jika diperlukan
    // ...
}

// Fungsi untuk menyembunyikan notifikasi
function hideCookieNotification() {
    const cookieNotification = document.getElementById('cookie-notification');
    if (cookieNotification) {
        cookieNotification.classList.add('hide');
        setTimeout(() => {
            cookieNotification.remove();
        }, 500); // Hapus setelah animasi selesai
    }
}

// Jalankan saat dokumen sudah siap
document.addEventListener('DOMContentLoaded', function() {
    // Tampilkan notifikasi cookies setelah halaman dimuat
    setTimeout(showCookieNotification, 1000);
});
