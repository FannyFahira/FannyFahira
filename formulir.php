<?php
// index.php - Formulir pengunjung perpustakaan yang menyimpan data ke file CSV
session_start();

// Fungsi untuk validasi input
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Nama file CSV untuk menyimpan data
$file = 'data_pengunjung.csv';

// Cek apakah file sudah ada, jika belum maka buat header
if (!file_exists($file)) {
    $header = array('Nama', 'NIM/ID', 'Jurusan/Fakultas', 'Tujuan', 'Tanggal', 'Waktu');
    $fp = fopen($file, 'w');
    fputcsv($fp, $header);
    fclose($fp);
}

// Inisialisasi variabel pesan
$pesan = '';
$status = '';

// Proses form jika sudah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi dan ambil data input
    $nama = validate_input($_POST['nama']);
    $nim = validate_input($_POST['nim']);
    $jurusan = validate_input($_POST['jurusan']);
    $tujuan = validate_input($_POST['tujuan']);
    $tanggal = date('Y-m-d');
    $waktu = date('H:i:s');
    
    // Simpan data ke CSV
    $data = array($nama, $nim, $jurusan, $tujuan, $tanggal, $waktu);
    $fp = fopen($file, 'a');
    if (fputcsv($fp, $data)) {
        $pesan = "Data kunjungan berhasil disimpan!";
        $status = "success";
    } else {
        $pesan = "Gagal menyimpan data kunjungan!";
        $status = "danger";
    }
    fclose($fp);
    
    // Set session untuk menampilkan pesan
    $_SESSION['pesan'] = $pesan;
    $_SESSION['status'] = $status;
    
    // Redirect untuk menghindari resubmisi form
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Ambil pesan dari session jika ada
if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    $status = $_SESSION['status'];
    unset($_SESSION['pesan']);
    unset($_SESSION['status']);
}

// Fungsi untuk membaca data pengunjung hari ini
function get_today_visitors() {
    global $file;
    $visitors = array();
    
    if (file_exists($file)) {
        $today = date('Y-m-d');
        if (($handle = fopen($file, "r")) !== FALSE) {
            // Skip header
            fgetcsv($handle);
            
            while (($data = fgetcsv($handle)) !== FALSE) {
                // Cek apakah kunjungan hari ini
                if ($data[4] == $today) {
                    $visitors[] = $data;
                }
            }
            fclose($handle);
        }
    }
    
    return $visitors;
}

// Ambil data pengunjung hari ini
$today_visitors = get_today_visitors();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Kunjungan Perpustakaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
            padding-bottom: 50px;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .data-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .table-header {
            background-color: #343a40;
            color: white;
        }
        h1 {
            font-weight: 700;
        }
        .lead {
            font-size: 1.1rem;
        }
        .icon {
            font-size: 24px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header text-center">
            <h1><i class="icon">📚</i> Formulir Kunjungan Perpustakaan</h1>
            <p class="lead">Silakan isi data kunjungan Anda untuk keperluan administrasi</p>
        </div>
        
        <?php if($pesan != ''): ?>
        <div class="alert alert-<?php echo $status; ?> alert-dismissible fade show" role="alert">
            <?php echo $pesan; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <div class="row">
            <!-- Form Kunjungan -->
            <div class="col-lg-5">
                <div class="form-container">
                    <h3 class="mb-4">Data Pengunjung</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM/ID Pengunjung</label>
                            <input type="text" class="form-control" id="nim" name="nim" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan/Fakultas</label>
                            <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan Kunjungan</label>
                            <select class="form-select" id="tujuan" name="tujuan" required>
                                <option value="" selected disabled>Pilih tujuan kunjungan</option>
                                <option value="Membaca Buku">Membaca Buku</option>
                                <option value="Meminjam Buku">Meminjam Buku</option>
                                <option value="Mengembalikan Buku">Mengembalikan Buku</option>
                                <option value="Menggunakan Komputer/Internet">Menggunakan Komputer/Internet</option>
                                <option value="Belajar/Mengerjakan Tugas">Belajar/Mengerjakan Tugas</option>
                                <option value="Diskusi Kelompok">Diskusi Kelompok</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Kirim Data Kunjungan</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Data Kunjungan Hari Ini -->
            <div class="col-lg-7">
                <div class="data-container">
                    <h3 class="mb-4">Data Kunjungan Hari Ini</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-header">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIM/ID</th>
                                    <th>Jurusan</th>
                                    <th>Tujuan</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($today_visitors) > 0): ?>
                                    <?php $no = 1; foreach ($today_visitors as $visitor): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $visitor[0]; ?></td>
                                            <td><?php echo $visitor[1]; ?></td>
                                            <td><?php echo $visitor[2]; ?></td>
                                            <td><?php echo $visitor[3]; ?></td>
                                            <td><?php echo date('H:i', strtotime($visitor[5])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data kunjungan hari ini</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-muted">Total pengunjung hari ini: <strong><?php echo count($today_visitors); ?></strong></p>
                    </div>
                </div>
                
                <!-- Informasi Tambahan -->
                <div class="data-container mt-4">
                    <h4>Informasi Perpustakaan</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Jam Operasional: Senin - Jumat, 08.00 - 16.00</li>
                        <li class="list-group-item">Maksimal Peminjaman: 3 buku selama 7 hari</li>
                        <li class="list-group-item">Denda Keterlambatan: Rp 1.000/hari/buku</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <footer class="mt-5 text-center text-muted">
            <p>© <?php echo date('Y'); ?> Perpustakaan. Develop by PHP.</p>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>