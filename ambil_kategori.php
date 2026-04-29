<?php 
include 'koneksi.php'; 

$sql = "SELECT * FROM kategori_artikel ORDER BY id DESC";
$query = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Data Kategori Artikel</h4>
    <button class="btn btn-tambah-kustom" onclick="showFormKategori()">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </button>
</div>

<div class="bg-white p-4 shadow-sm" style="border-radius: 15px;">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr class="small text-uppercase fw-bold text-muted">
                    <th style="width: 25%;">Nama Kategori</th>
                    <th style="width: 50%;">Keterangan</th>
                    <th class="text-center" style="width: 25%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($query) > 0) {
                    while($d = mysqli_fetch_array($query)) { ?>
                <tr>
                    <td><span class="badge bg-primary-subtle text-primary px-3 py-2"><?= $d['nama_kategori'] ?></span></td>
                    <td class="text-muted small"><?= $d['keterangan'] ?></td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm px-3 me-1" style="border-radius: 5px;" 
                                onclick="editKategori('<?= $d['id'] ?>', '<?= addslashes($d['nama_kategori']) ?>', '<?= addslashes($d['keterangan']) ?>')">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm px-3" style="border-radius: 5px;" onclick="konfirmasiHapusKategori('<?= $d['id'] ?>')">
                            Hapus
                        </button>
                    </td>
                </tr>
                <?php } } else { ?>
                <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada kategori.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>