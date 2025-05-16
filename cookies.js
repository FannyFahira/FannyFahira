// Perpustakaan Fanny Fahira - Cookie Management Script
// Fungsi untuk mengatur cookie
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
}

// Fungsi untuk mendapatkan nilai cookie berdasarkan nama
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

// Fungsi untuk menghapus cookie
function eraseCookie(name) {
    document.cookie = name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}

// Fungsi untuk memeriksa apakah ini kunjungan pertama
function checkFirstVisit() {
    const visited = getCookie("visited");
    if (!visited) {
        // Set cookie bahwa pengguna telah mengunjungi situs
        setCookie("visited", "true", 30); // Berlaku selama 30 hari
        return true;
    }
    return false;
}

// Fungsi untuk menyimpan preferensi tema
function saveThemePreference(theme) {
    setCookie("theme", theme, 365); // Simpan preferensi tema selama 1 tahun
}

// Fungsi untuk mendapatkan preferensi tema
function getThemePreference() {
    return getCookie("theme") || "light"; // Default ke light jika tidak ada
}

// Fungsi untuk menyimpan preferensi buku terakhir dilihat
function saveLastViewedBook(bookId, bookTitle) {
    const bookInfo = {
        id: bookId,
        title: bookTitle,
        timestamp: new Date().getTime()
    };
    setCookie("lastViewedBook", JSON.stringify(bookInfo), 7); // Simpan selama 7 hari
}

// Fungsi untuk mendapatkan buku terakhir dilihat
function getLastViewedBook() {
    const bookInfo = getCookie("lastViewedBook");
    if (bookInfo) {
        try {
            return JSON.parse(bookInfo);
        } catch (e) {
            console.error("Error parsing lastViewedBook cookie:", e);
            return null;
        }
    }
    return null;
}

// Fungsi untuk menyimpan bahasa yang dipilih
function saveLanguagePreference(language) {
    setCookie("language", language, 365); // Simpan selama 1 tahun
}

// Fungsi untuk mendapatkan bahasa yang dipilih
function getLanguagePreference() {
    return getCookie("language") || "id"; // Default ke Bahasa Indonesia
}

// Fungsi untuk menyimpan persetujuan cookie
function saveCookieConsent(consent) {
    setCookie("cookieConsent", consent ? "true" : "false", 365); // Simpan selama 1 tahun
}

// Fungsi untuk memeriksa persetujuan cookie
function checkCookieConsent() {
    return getCookie("cookieConsent") === "true";
}

// Fungsi untuk menampilkan pemberitahuan persetujuan cookie
function showCookieConsent() {
    // Jika belum memberikan persetujuan, tampilkan pemberitahuan
    if (getCookie("cookieConsent") === null) {
        // Buat elemen banner persetujuan cookie
        const consentBanner = document.createElement('div');
        consentBanner.id = 'cookie-consent-banner';
        consentBanner.innerHTML = `
            <div class="cookie-content">
                <div class="cookie-text">
                    <h3>Kami Menggunakan Cookies</h3>
                    <p>Website ini menggunakan cookies untuk meningkatkan pengalaman Anda. Dengan melanjutkan, Anda menyetujui penggunaan cookies sesuai kebijakan kami.</p>
                </div>
                <div class="cookie-buttons">
                    <button id="accept-cookies" class="consent-btn accept">Setuju</button>
                    <button id="decline-cookies" class="consent-btn decline">Tolak</button>
                    <a href="#" id="privacy-policy-link">Kebijakan Privasi</a>
                </div>
            </div>
        `;
        
        document.body.appendChild(consentBanner);
        
        // Tambahkan event listener untuk tombol setuju
        document.getElementById('accept-cookies').addEventListener('click', function() {
            saveCookieConsent(true);
            consentBanner.style.transform = 'translateY(100%)';
            setTimeout(() => {
                consentBanner.remove();
            }, 500);
        });
        
        // Tambahkan event listener untuk tombol tolak
        document.getElementById('decline-cookies').addEventListener('click', function() {
            saveCookieConsent(false);
            consentBanner.style.transform = 'translateY(100%)';
            setTimeout(() => {
                consentBanner.remove();
            }, 500);
        });
    }
}

// Fungsi untuk menerapkan tema dari cookie
function applyThemeFromCookie() {
    const theme = getThemePreference();
    document.body.classList.remove('light-theme', 'dark-theme');
    document.body.classList.add(theme + '-theme');
}

// Fungsi untuk menyimpan riwayat pencarian
function saveSearchHistory(searchTerm) {
    let searchHistory = [];
    const storedHistory = getCookie("searchHistory");
    
    if (storedHistory) {
        try {
            searchHistory = JSON.parse(storedHistory);
            // Batasi riwayat pencarian maksimal 5 item
            if (searchHistory.length >= 5) {
                searchHistory.pop(); // Hapus yang paling lama
            }
        } catch (e) {
            console.error("Error parsing searchHistory cookie:", e);
        }
    }
    
    // Tambahkan pencarian baru ke awal array
    searchHistory.unshift({
        term: searchTerm,
        timestamp: new Date().getTime()
    });
    
    setCookie("searchHistory", JSON.stringify(searchHistory), 30); // Simpan selama 30 hari
}

// Fungsi untuk mendapatkan riwayat pencarian
function getSearchHistory() {
    const history = getCookie("searchHistory");
    if (history) {
        try {
            return JSON.parse(history);
        } catch (e) {
            console.error("Error parsing searchHistory cookie:", e);
            return [];
        }
    }
    return [];
}

// Inisialisasi fungsi ketika DOM sudah siap
document.addEventListener('DOMContentLoaded', function() {
    // Tampilkan banner persetujuan cookie
    showCookieConsent();
    
    // Terapkan tema dari cookie jika ada
    applyThemeFromCookie();
    
    // Periksa apakah ini kunjungan pertama pengguna
    if (checkFirstVisit()) {
        // Bisa menampilkan modal "Selamat Datang" untuk kunjungan pertama
        console.log("Kunjungan pertama terdeteksi");
    }
    
    // Tambahkan event listener untuk input pencarian
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter' && this.value.trim() !== '') {
                saveSearchHistory(this.value.trim());
            }
        });
    }
    
    // Tambahkan event listener untuk cover buku
    const bookCards = document.querySelectorAll('.book-card');
    bookCards.forEach(card => {
        card.addEventListener('click', function() {
            const bookTitle = this.querySelector('.overlay h3').textContent;
            const bookId = this.getAttribute('data-book-id') || Math.random().toString(36).substring(2, 9);
            saveLastViewedBook(bookId, bookTitle);
        });
    });
});
