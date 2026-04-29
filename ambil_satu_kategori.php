<?php 
include 'koneksi.php'; 
header('Content-Type: application/json');

// Ini harus mengambil dari tabel kategori_artikel
$q = mysqli_query($conn, "SELECT * FROM kategori_artikel");

if (!$q) {
    echo json_encode(["error" => mysqli_error($conn)]);
    exit;
}

$data = mysqli_fetch_all($q, MYSQLI_ASSOC);
echo json_encode($data);
?>