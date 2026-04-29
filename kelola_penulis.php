<?php
include 'koneksi.php';

// Ambil data penulis dari database
$query = mysqli_query($koneksi, "SELECT * FROM penulis");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Penulis</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
        .btn-action {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Data Penulis</h2>
    <a href="tambah_penulis.php" class="btn btn-success mb-3">+ Tambah Penulis</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Password</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td>
                    <?php if($row['foto']): ?>
                        <img src="uploads/<?= $row['foto'] ?>" class="table-img" alt="Foto Profil">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/40" class="table-img" alt="No Foto">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td>********</td>
                <td>
                    <a href="edit_penulis.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-action">Edit</a>
                    <a href="hapus_penulis.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-action" onclick="return confirm('Hapus data ini? Data yang dihapus tidak dapat dikembalikan.');">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
