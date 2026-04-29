<?php 
include 'koneksi.php';
$q = mysqli_query($conn, "SELECT * FROM penulis ORDER BY id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Data Penulis</h4>
    <button class="btn btn-tambah-kustom" onclick="showFormPenulis()">
        <i class="fa-solid fa-plus"></i> Tambah Penulis
    </button>
</div>

<table class="table table-hover align-middle m-0">
    <thead class="table-light">
        <tr>
            <th width="10%">FOTO</th>
            <th width="25%">NAMA</th>
            <th width="20%" class="text-center">USERNAME</th>
            <th width="25%">PASSWORD</th>
            <th width="20%" class="text-center">AKSI</th>
        </tr>
    </thead>
    <tbody>
        <?php while($d = mysqli_fetch_assoc($q)) { 
            $foto_nama = !empty($d['foto']) ? $d['foto'] : 'default.png';
            $foto_path = "upload_penulis/" . $foto_nama;
            
            // Kita bersihkan data dari tanda petik supaya tidak error di JavaScript
            $depan = addslashes($d['nama_depan']);
            $belakang = addslashes($d['nama_belakang']);
            $user = addslashes($d['user_name']);
        ?>
            <tr>
                <td>
                    <img src="<?= $foto_path ?>" 
                         class="img-profile" 
                         onerror="this.onerror=null; this.src='upload_penulis/default.png';">
                </td>
                <td style="font-weight: 500; color: #22364d;"><?= htmlspecialchars($d['nama_depan'] . ' ' . $d['nama_belakang']) ?></td>
                <td class="text-center">
                    <span class="badge-username"><?= htmlspecialchars($d['user_name']) ?></span>
                </td>
                <td>
                    <span class="text-password"><?= substr($d['password'], 0, 12) ?>...</span>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary px-3 me-1" 
                            style="border-radius: 8px;"
                            onclick="editPenulisLangsung('<?= $d['id'] ?>', '<?= $depan ?>', '<?= $belakang ?>', '<?= $user ?>')">
                        Edit
                    </button>
                    
                    <button class="btn btn-sm btn-danger px-3" 
                            style="border-radius: 8px;"
                            onclick="hapusPenulis(<?= $d['id'] ?>)">
                        Hapus
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>