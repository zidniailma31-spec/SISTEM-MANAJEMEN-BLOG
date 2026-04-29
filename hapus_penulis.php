<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cari nama file foto untuk dihapus dari folder
    $queryFoto = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
    $queryFoto->bind_param("i", $id);
    $queryFoto->execute();
    $result = $queryFoto->get_result();
    $data = $result->fetch_assoc();

    if ($data && $data['foto'] != 'default.png') {
        $path = "uploads_penulis/" . $data['foto'];
        if (file_exists($path)) { unlink($path); }
    }

    // Hapus dari DB
    $stmt = $conn->prepare("DELETE FROM penulis WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>