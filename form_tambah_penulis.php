<?php
// Form tambah penulis, tampilan modern sesuai desain
?>
<div style="max-width:400px;margin:auto;">
  <h4 class="mb-3">Tambah Penulis</h4>
  <form method="post" action="simpan_penulis.php" enctype="multipart/form-data">
    <div class="mb-2">
      <label class="form-label">Nama Depan</label>
      <input type="text" name="nama_depan" class="form-control" required>
    </div>
    <div class="mb-2">
      <label class="form-label">Nama Belakang</label>
      <input type="text" name="nama_belakang" class="form-control" required>
    </div>
    <div class="mb-2">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-2">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Foto Profil</label>
      <input type="file" name="foto" class="form-control">
    </div>
    <div class="d-flex justify-content-between">
      <button type="button" class="btn btn-secondary" onclick="setMenu('penulis')">Batal</button>
      <button type="submit" class="btn btn-success">Simpan Data</button>
    </div>
  </form>
</div>
