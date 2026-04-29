<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen Blog (CMS)</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f5fa; font-family: 'Segoe UI', sans-serif; }
        .cms-header { background: #22364d; color: #fff; padding: 25px 40px; }
        .cms-header h4 { margin: 0; font-weight: 600; }
        .cms-header span { font-size: 0.85rem; color: #b8c7e0; }
        .cms-main { display: flex; padding: 40px; gap: 30px; }
        .cms-sidebar { background: #fff; width: 260px; border-radius: 16px; padding: 20px 0; box-shadow: 0 2px 12px rgba(0,0,0,0.05); height: fit-content; }
        .cms-menu-btn i { color: #6c757d; font-size: 1.1rem; width: 25px; text-align: center; }
        .cms-menu-btn { display: flex; align-items: center; gap: 12px; background: none; border: none; width: 100%; padding: 12px 25px; color: #444; font-weight: 500; transition: 0.3s; }
        .cms-menu-btn.active { background: #eaf7ef; color: #198754; border-left: 4px solid #198754; }
        .cms-content-wrapper { flex: 1; }
        .cms-card { background: #fff; border-radius: 18px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); }
        .img-profile { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; }
        .badge-username { background-color: #e3f2fd; color: #0d47a1; padding: 4px 12px; border-radius: 6px; font-size: 0.85rem; border: 1px solid #bbdefb; display: inline-block; font-weight: 500; }
        .text-password { color: #a0a0a0; font-size: 0.85rem; font-family: 'Courier New', Courier, monospace; display: block; }
        /* Warna Hijau Konsisten untuk Semua Tombol Tambah */
.btn-tambah-kustom {
    background-color: #198754 !important; /* Warna hijau emerald yang bersih */
    border-color: #198754 !important;
    color: white !important;
    font-weight: 600;
    font-size: 0.9rem; /* Ukuran font standar */
    padding: 8px 16px; /* Jarak atas-bawah 8px, kiri-kanan 16px */
    border-radius: 8px; /* Sudut melengkung yang modern */
    display: flex;
    align-items: center;
    gap: 8px; /* Jarak antara ikon + dan tulisan */
    transition: all 0.3s ease;
}

.btn-tambah-kustom:hover {
    background-color: #157347 !important; /* Warna sedikit lebih gelap saat disentuh */
    transform: translateY(-1px); /* Efek melayang sedikit */
}
        /* SweetAlert Trash Custom */
        .swal-icon-trash-custom { background-color: #fff0f1 !important; width: 80px !important; height: 80px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; margin: 20px auto 10px !important; border: none !important; }
        .swal-icon-trash-custom i { font-size: 32px !important; color: #eb4d4b !important; }
        .swal2-confirm { border-radius: 8px !important; padding: 10px 24px !important; font-weight: 600 !important; }
        .swal2-cancel { border-radius: 8px !important; padding: 10px 24px !important; }

    </style>
</head>
<body>

<div class="cms-header">
    <div class="d-flex align-items-center">
        <div class="me-3 d-flex align-items-center justify-content-center" style="background: rgba(211, 18, 18, 0.1); width: 45px; height: 45px; border-radius: 12px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="3" y1="9" x2="21" y2="9"></line>
                <line x1="9" y1="21" x2="9" y2="9"></line>
            </svg>
        </div>
        <div>
            <h4 class="m-0">Sistem Manajemen Blog (CMS)</h4>
            <span>Blog Keren</span>
        </div>
    </div>
</div>

<div class="cms-main">
    <aside class="cms-sidebar">
    <div class="px-4 mb-3 text-muted" style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Menu Utama</div>

    <button class="cms-menu-btn active" onclick="setMenu('penulis')">
        <i class="fa-regular fa-user"></i> Kelola Penulis
    </button>
    
    <button class="cms-menu-btn" onclick="setMenu('artikel')">
        <i class="fa-regular fa-file-lines"></i> Kelola Artikel
    </button>
    
    <button class="cms-menu-btn" onclick="setMenu('kategori')">
        <i class="fa-regular fa-folder"></i> Kelola Kategori
    </button>
</aside>
    
    <div class="cms-content-wrapper">
        <div class="cms-card" id="konten"></div>
    </div>
</div>

<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="modalBody"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const myModal = new bootstrap.Modal(document.getElementById('modalForm'));

    // --- 1. NAVIGASI MENU ---
    function setMenu(menu) {
        document.querySelectorAll('.cms-menu-btn').forEach(b => b.classList.remove('active'));
        if(event) event.currentTarget.classList.add('active');
        loadData(menu);
    }

    function loadData(menu) {
        const container = document.getElementById('konten'); 
        fetch('ambil_' + menu + '.php')
            .then(response => response.text())
            .then(data => { container.innerHTML = data; })
            .catch(err => { container.innerHTML = `<div class="p-4 text-danger">Gagal memuat data.</div>`; });
    }

    // --- 2. FUNGSI HAPUS ---
    function hapusData(id, tipe) {
       let url = tipe === 'penulis' ? `hapus_penulis.php?id=${id}` : `hapus_artikel.php?id=${id}`;
        Swal.fire({
            title: 'Hapus data ini?',
            text: "Data yang dihapus tidak dapat dikembalikan.",
            iconHtml: '<div class="swal-icon-trash-custom"><i class="fa-solid fa-trash-can"></i></div>',
            showCancelButton: true,
            confirmButtonColor: '#f24e1e',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: { icon: 'border-0', popup: 'rounded-4' }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url).then(() => {
                    loadData(tipe); 
                    Swal.fire({ title: 'Terhapus!', icon: 'success', timer: 1500, showConfirmButton: false });
                });
            }
        });
    }

    function hapusPenulis(id) { hapusData(id, 'penulis'); }
    function hapusArtikel(id) { hapusData(id, 'artikel'); }

    // --- 3. FUNGSI PENULIS ---
    function showFormPenulis() {
        document.getElementById('modalTitle').innerHTML = '<strong>Tambah Penulis</strong>';
        document.getElementById('modalBody').innerHTML = `
            <form id="formSimpanPenulis" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col"><label class="form-label small fw-bold">Nama Depan</label><input type="text" name="nama_depan" class="form-control" required></div>
                    <div class="col"><label class="form-label small fw-bold">Nama Belakang</label><input type="text" name="nama_belakang" class="form-control" required></div>
                </div>
                <div class="mb-3"><label class="form-label small fw-bold">Username</label><input type="text" name="user_name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label small fw-bold">Password</label><input type="password" name="password" class="form-control" required></div>
                <div class="mb-4"><label class="form-label small fw-bold">Foto Profil</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4">Simpan Data</button>
                </div>
            </form>
        `;
        myModal.show();
        document.getElementById('formSimpanPenulis').onsubmit = function(e) {
            e.preventDefault();
            fetch('simpan_penulis.php', { method: 'POST', body: new FormData(this) }).then(() => { 
                myModal.hide(); loadData('penulis'); 
            });
        };
    }

    function editPenulisLangsung(id, depan, belakang, user, pass) {
        document.getElementById('modalTitle').innerHTML = '<strong>Edit Penulis</strong>';
        document.getElementById('modalBody').innerHTML = `
            <form id="formUpdatePenulis" enctype="multipart/form-data">
                <input type="hidden" name="id" value="${id}">
                <div class="row mb-3">
                    <div class="col"><label class="form-label small fw-bold">Nama Depan</label><input type="text" name="nama_depan" class="form-control" value="${depan}" required></div>
                    <div class="col"><label class="form-label small fw-bold">Nama Belakang</label><input type="text" name="nama_belakang" class="form-control" value="${belakang}" required></div>
                </div>
                <div class="mb-3"><label class="form-label small fw-bold">Username</label><input type="text" name="user_name" class="form-control" value="${user}" required></div>
                <div class="mb-3"><label class="form-label small fw-bold">Password</label><input type="text" name="password" class="form-control" value="${pass}" required></div>
                <div class="mb-4"><label class="form-label small fw-bold">Ganti Foto Profil</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
            <div class="d-flex justify-content-end gap-2 border-top pt-3">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 8px; background-color: #9ca3af; border: none;">Batal</button>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 8px; background-color: #329335; border: none;">Simpan Perubahan</button>
            </div>
                </div>
            </form>
        `;
        myModal.show();
        document.getElementById('formUpdatePenulis').onsubmit = function(e) {
            e.preventDefault();
            fetch('update_penulis.php', { method: 'POST', body: new FormData(this) }).then(() => { 
                myModal.hide(); loadData('penulis'); 
            });
        };
    }

    // --- 4. FUNGSI ARTIKEL ---
 function editArtikelLangsung(id, judul, isi, id_penulis, id_kategori) {
    document.getElementById('modalTitle').innerHTML = '<h5 class="fw-bold">Edit Artikel</h5>';
    document.getElementById('modalBody').innerHTML = `
        <form id="formUpdateArtikel" enctype="multipart/form-data">
            <input type="hidden" name="id" value="${id}">
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Judul</label>
                <input type="text" name="judul" class="form-control" value="${judul}" required style="border-radius: 8px; padding: 10px;">
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Penulis</label>
                    <select name="id_penulis" id="edit_optPenulis" class="form-select" required style="border-radius: 8px; padding: 10px;">
                        <option value="">Loading...</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Kategori</label>
                    <select name="id_kategori" id="edit_optKategori" class="form-select" required style="border-radius: 8px; padding: 10px;">
                        <option value="">Loading...</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Isi Artikel</label>
                <textarea name="isi" class="form-control" rows="5" required style="border-radius: 8px; padding: 10px;">${isi}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Ganti Gambar (Opsional)</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" style="border-radius: 8px; padding: 10px;">
            </div>

            <div class="d-flex justify-content-end gap-2 border-top pt-3">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 8px; background-color: #9ca3af; border: none;">Batal</button>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 8px; background-color: #329335; border: none;">Simpan Perubahan</button>
            </div>
        </form>
    `;

    myModal.show();

    // LOAD DATA KATEGORI
    fetch('ambil_satu_kategori.php')
        .then(r => r.json())
        .then(data => {
            let optK = document.getElementById('edit_optKategori');
            optK.innerHTML = '<option value="">Pilih Kategori</option>';
            data.forEach(k => {
                let selected = (k.id == id_kategori) ? 'selected' : '';
                optK.innerHTML += `<option value="${k.id}" ${selected}>${k.nama_kategori}</option>`;
            });
        })
        .catch(err => console.error("Error Kategori:", err));

    // LOAD DATA PENULIS
    fetch('ambil_satu_penulis.php')
        .then(r => r.json())
        .then(data => {
            let optP = document.getElementById('edit_optPenulis');
            optP.innerHTML = '<option value="">Pilih Penulis</option>';
            data.forEach(p => {
                let selected = (p.id == id_penulis) ? 'selected' : '';
                // Gunakan p.nama jika di PHP kamu pakai AS nama, atau p.nama_depan jika tidak
                let namaTampil = p.nama ? p.nama : `${p.nama_depan} ${p.nama_belakang || ''}`;
                optP.innerHTML += `<option value="${p.id}" ${selected}>${namaTampil}</option>`;
            });
        })
        .catch(err => console.error("Error Penulis:", err));

    document.getElementById('formUpdateArtikel').onsubmit = function(e) {
        e.preventDefault();
        fetch('update_artikel.php', { method: 'POST', body: new FormData(this) })
        .then(() => {
            myModal.hide();
            loadData('artikel');
            Swal.fire({ title: 'Berhasil!', text: 'Artikel diperbarui.', icon: 'success', timer: 1500, showConfirmButton: false });
        });
    };
}

// --- 1. FUNGSI TAMBAH ARTIKEL ---
function showFormArtikel() {
    document.getElementById('modalTitle').innerHTML = '<h5 class="fw-bold m-0">Tambah Artikel</h5>';
    document.getElementById('modalBody').innerHTML = `
        <form id="formSimpanArtikel" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Judul</label>
                <input type="text" name="judul" class="form-control" placeholder="Judul artikel..." required style="border-radius: 8px;">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Penulis</label>
                    <select name="id_penulis" id="optPenulis" class="form-select" required style="border-radius: 8px;">
                        <option value="">Pilih Penulis</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Kategori</label>
                    <select name="id_kategori" id="optKategori" class="form-select" required style="border-radius: 8px;">
                        <option value="">Pilih Kategori</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Isi Artikel</label>
                <textarea name="isi" class="form-control" rows="5" required style="border-radius: 8px;"></textarea>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Gambar</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" required style="border-radius: 8px;">
            </div>
            <div class="d-flex justify-content-end gap-2 border-top pt-3">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 8px; background-color: #4caf50; border:none;">Simpan Data</button>
            </div>
        </form>
    `;

    myModal.show();

    // Ambil data penulis
    fetch('ambil_satu_penulis.php')
        .then(r => r.json())
        .then(data => {
            let opt = document.getElementById('optPenulis');
            data.forEach(p => {
                opt.innerHTML += `<option value="${p.id}">${p.nama_depan} ${p.nama_belakang || ''}</option>`;
            });
        });

    // Ambil data kategori
   fetch('ambil_satu_kategori.php')
    .then(r => r.json())
    .then(data => {
        let optK = document.getElementById('optKategori'); 
        optK.innerHTML = '<option value="">Pilih Kategori</option>'; 
        
        data.forEach(k => {
            // PERHATIKAN: k.nama_kategori harus sama dengan di PHP
            optK.innerHTML += `<option value="${k.id}">${k.nama_kategori}</option>`;
        });
    });

    document.getElementById('formSimpanArtikel').onsubmit = function(e) {
        e.preventDefault();
        fetch('simpan_artikel.php', { method: 'POST', body: new FormData(this) })
            .then(() => {
                myModal.hide();
                loadData('artikel');
                Swal.fire({ title: 'Berhasil!', text: 'Artikel disimpan.', icon: 'success', timer: 1500 });
            });
    };
}

// --- 2. FUNGSI TAMBAH KATEGORI ---
function showFormKategori() {
    document.getElementById('modalTitle').innerHTML = '<h5 class="fw-bold m-0">Tambah Kategori</h5>';
    document.getElementById('modalBody').innerHTML = `
        <form id="formSimpanKategori">
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" placeholder="Nama kategori..." required style="border-radius: 8px;">
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="4" required style="border-radius: 8px;"></textarea>
            </div>
            <div class="d-flex justify-content-end gap-2 border-top pt-3">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 8px; background-color: #4caf50; border:none;">Simpan Data</button>
            </div>
        </form>
    `;

    myModal.show();

    document.getElementById('formSimpanKategori').onsubmit = function(e) {
        e.preventDefault();
        fetch('simpan_kategori.php', { method: 'POST', body: new FormData(this) })
            .then(() => {
                myModal.hide();
                loadData('kategori');
                Swal.fire({ title: 'Berhasil!', text: 'Kategori baru ditambahkan.', icon: 'success', timer: 1500 });
            });
    };
}

// 2. FUNGSI EDIT (Gambar 12)
function editKategori(id, nama, ket) {
    document.getElementById('modalTitle').innerHTML = '<h5 class="fw-bold m-0">Edit Kategori</h5>';
    document.getElementById('modalBody').innerHTML = `
        <form id="formUpdateKategori">
            <input type="hidden" name="id" value="${id}">
            
            <div class="border-bottom pb-2 mb-3"></div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" value="${nama}" required style="border-radius: 8px; padding: 10px;">
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="4" required style="border-radius: 8px; padding: 10px;">${ket}</textarea>
            </div>

            <div class="d-flex justify-content-end gap-2 border-top pt-3">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 8px; background-color: #9ca3af; border: none;">Batal</button>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 8px; background-color: #4caf50; border: none;">Simpan Perubahan</button>
            </div>
        </form>
    `;
    myModal.show();

    document.getElementById('formUpdateKategori').onsubmit = function(e) {
        e.preventDefault();
        fetch('update_kategori.php', { method: 'POST', body: new FormData(this) })
        .then(() => {
            myModal.hide();
            loadData('kategori');
            Swal.fire({ title: 'Diperbarui!', text: 'Data kategori telah diubah.', icon: 'success', timer: 1500, showConfirmButton: false });
        });
    };
}

// 3. FUNGSI HAPUS (Gambar 13)
function konfirmasiHapusKategori(id) {
    Swal.fire({
        title: 'Hapus data ini?',
        text: "Data yang dihapus tidak dapat dikembalikan.",
        iconHtml: '<div style="background: #fff0f0; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-trash-can" style="color: #ef4444; font-size: 24px;"></i></div>',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: { icon: 'border-0' }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('hapus_kategori.php?id=' + id).then(() => {
                loadData('kategori');
                Swal.fire('Terhapus!', 'Kategori telah dihapus.', 'success');
            });
        }
    });
}
    window.onload = () => { loadData('penulis'); };
</script>
</body>
</html>