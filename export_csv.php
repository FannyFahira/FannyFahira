<?php
// export_csv.php - File untuk mengunduh data pengunjung dalam format CSV

// Mulai session
session_start();

// Set header untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="data_pengunjung_perpustakaan_' . date('Y-m-d') . '.csv"');

// Buka output file stream
$output = fopen('php://output', 'w');

// Tambahkan header CSV
fputcsv($output, array('Nama', 'NIM/ID', 'Jurusan/Fakultas', 'Tujuan', 'Tanggal', 'Waktu'));

// Path ke file CSV
$file = 'data_pengunjung.csv';

// Cek apakah file ada
if (file_exists($file)) {
    // Buka file untuk dibaca
    if (($handle = fopen($file, "r")) !== FALSE) {
        // Skip header
        fgetcsv($handle);
        
        // Baca data baris per baris
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Tulis ke output
            fputcsv($output, $data);
        }
        fclose($handle);
    }
}

// Tutup output stream
fclose($output);
exit;
?>