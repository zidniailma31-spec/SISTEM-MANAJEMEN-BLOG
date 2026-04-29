<?php include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');
$tanggal=date('d-m-Y H:i');
mysqli_query($conn,"INSERT INTO artikel(id_penulis,id_kategori,judul,isi,gambar,hari_tanggal) VALUES('$_POST[id_penulis]','$_POST[id_kategori]','$_POST[judul]','$_POST[isi]','default.png','$tanggal')");
?>