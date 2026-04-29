<?php
include 'koneksi.php';

// Ambil semua data penulis
$query = mysqli_query($conn, "SELECT id, nama_depan, nama_belakang FROM penulis");

// Masukkan ke dalam array
$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

// KIRIM SEBAGAI JSON (Sangat Penting!)
header('Content-Type: application/json');
echo json_encode($data);
?>