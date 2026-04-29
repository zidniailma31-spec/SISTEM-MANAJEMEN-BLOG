<?php include 'koneksi.php';
mysqli_query($conn,"INSERT INTO kategori_artikel(nama_kategori,keterangan) VALUES('$_POST[nama]','$_POST[keterangan]')");
?>