<?php
include 'koneksi.php';

$id = $_POST['id'];
$nama1 = $_POST['nama_depan'];
$nama2 = $_POST['nama_belakang'];
$user = $_POST['user_name'];
$pass = $_POST['password'];

// Ambil foto lama untuk jaga-jaga
$lama = mysqli_query($conn, "SELECT foto FROM penulis WHERE id='$id'");
$data_lama = mysqli_fetch_assoc($lama);
$foto = $data_lama['foto'];

// Cek jika ada upload foto baru
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $target_dir = "upload_penulis/";
    $nama_asli = str_replace(' ', '_', $_FILES["foto"]["name"]);
    $foto = time() . "_" . $nama_asli;
    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $foto);
}

// Cek jika password diganti
if (!empty($pass)) {
    $pass_hash = password_hash($pass, PASSWORD_BCRYPT);
    $sql = "UPDATE penulis SET nama_depan='$nama1', nama_belakang='$nama2', user_name='$user', password='$pass_hash', foto='$foto' WHERE id='$id'";
} else {
    $sql = "UPDATE penulis SET nama_depan='$nama1', nama_belakang='$nama2', user_name='$user', foto='$foto' WHERE id='$id'";
}

if (mysqli_query($conn, $sql)) { echo "success"; }
?>