<?php
include 'koneksi.php';

// Pastikan ada ID yang dikirim dari JavaScript
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Gunakan Prepared Statement supaya aman dari hacker
    $stmt = $conn->prepare("SELECT * FROM artikel WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Kirim data dalam format JSON supaya bisa dibaca JavaScript
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
} else {
    echo json_encode(['error' => 'ID tidak tersedia']);
}
?>