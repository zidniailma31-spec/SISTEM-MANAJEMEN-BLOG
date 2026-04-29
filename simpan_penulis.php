<?php
include 'koneksi.php';

$nama1 = $_POST['nama_depan'];
$nama2 = $_POST['nama_belakang'];
$user = $_POST['user_name'];
$pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

// 1. Default foto jika tidak ada yang diupload
$foto = 'default.png';

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    // 2. SESUAIKAN: Hilangkan huruf 's' agar jadi upload_penulis/
    $target_dir = "upload_penulis/"; 
    
    // 3. Bersihkan nama file dari spasi agar tidak error saat dipanggil
    $nama_asli = str_replace(' ', '_', $_FILES["foto"]["name"]);
    $foto = time() . "_" . basename($nama_asli);
    
    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $foto);
}

$stmt = $conn->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $nama1, $nama2, $user, $pass, $foto);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}
?>