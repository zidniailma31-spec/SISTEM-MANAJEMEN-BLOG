<?php 
include 'koneksi.php'; 

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal. Cek file koneksi.php");
}

$sql = "SELECT artikel.*, kategori_artikel.nama_kategori, penulis.nama_depan, penulis.nama_belakang 
        FROM artikel 
        LEFT JOIN kategori_artikel ON artikel.id_kategori = kategori_artikel.id 
        LEFT JOIN penulis ON artikel.id_penulis = penulis.id 
        ORDER BY artikel.id DESC";

$query = mysqli_query($conn, $sql);

if (!$query) {
    die("Error Query: " . mysqli_error($conn));
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Data Artikel</h4>
    <button class="btn btn-tambah-kustom" onclick="showFormArtikel()">
        <i class="fa-solid fa-plus"></i> Tambah Artikel
    </button>
</div>

<div class="bg-white p-4 shadow-sm" style="border-radius: 15px;">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr class="text-muted small">
                    <th>GAMBAR</th>
                    <th>JUDUL</th>
                    <th>KATEGORI</th>
                    <th>PENULIS</th>
                    <th>TANGGAL</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($query) > 0) {
                    while($d = mysqli_fetch_array($query)) { ?>
                <tr>
                    <td>
                        <div class="bg-light text-center py-2" style="width:50px; border-radius:5px; font-size:10px; font-weight:bold; color:#999;">
                            <?= strtoupper(pathinfo($d['gambar'] ?? '', PATHINFO_EXTENSION)) ?: 'IMG' ?>
                        </div>
                    </td>
                    <td><span class="fw-bold"><?= $d['judul'] ?></span></td>
                    <td><span class="badge bg-primary-subtle text-primary px-3"><?= $d['nama_kategori'] ?? 'Tanpa Kategori' ?></span></td>
                    <td class="text-muted"><?= ($d['nama_depan'] ?? 'Anonim') . " " . ($d['nama_belakang'] ?? '') ?></td>
                    <td>
    <?php 
    if (!empty($d['hari_tanggal'])) {
        // Mengubah format tanggal database ke bahasa Indonesia
        $waktu = strtotime($d['hari_tanggal']);
        $hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        $bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        echo $hari[date("w", $waktu)] . ", " . date("j", $waktu) . " " . $bulan[date("n", $waktu)] . " " . date("Y", $waktu) . " | " . date("H:i", $waktu);
    } else {
        echo "-";
    }
    ?>
</td>
                    
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm px-3 me-1" style="border-radius: 8px;" 
                                onclick="editArtikelLangsung('<?= $d['id'] ?>', '<?= addslashes($d['judul']) ?>', '<?= addslashes($d['isi']) ?>', '<?= $d['id_penulis'] ?>', '<?= $d['id_kategori'] ?>')">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm px-3" style="border-radius: 8px;" onclick="hapusArtikel('<?= $d['id'] ?>')">
                            Hapus
                        </button>
                    </td>
                </tr>
                <?php } } else { ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada artikel.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>