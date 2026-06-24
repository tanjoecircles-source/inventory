# Product Requirement Document (PRD) - Fitur Pengajuan Stok Bahan

## 1. Ringkasan Fitur (Feature Summary)
* **Nama Fitur:** Pengajuan Stok Bahan
* **Modul/Sistem:** Manajemen Inventaris / Gudang (Toko Kopi Tanjoe)
* **Versi:** 1.0
* **Status:** Draft / Review

## 2. Latar Belakang & Tujuan (Background & Objectives)
Untuk menjaga ketersediaan bahan baku di gerai/outlet, diperlukan sistem pencatatan yang terstruktur untuk mengajukan penambahan stok bahan (seperti biji kopi, susu, sirup, cup, dll.). Fitur ini bertujuan memudahkan staf operasional/barista (Author) membuat pengajuan, serta memudahkan manajer/pemilik dalam melacak, menyetujui, atau menolak pengajuan tersebut secara sistematis.

## 3. Komponen Antarmuka Pengguna (UI Specs - Halaman Utama)
Berdasarkan referensi layout yang diberikan, halaman utama fitur ini akan mengadopsi struktur *list-view* berbasis kartu (card) dengan komponen sebagai berikut:

### A. Header & Navigasi
* **Judul Utama:** "Pengajuan Stok Bahan"
* **Sub-judul:** "Daftar Riwayat dan Status Pengajuan Stok Bahan Baku"
* **Tombol Kembali:** Icon `←` untuk kembali ke halaman dasbor utama.

### B. Komponen Pencarian (Search Bar)
* **Placeholder Text:** "Cari berdasarkan Author atau Status..."
* **Fungsi:** Menyaring daftar pengajuan secara *real-time* berdasarkan nama pembuat pengajuan atau statusnya.

### C. Konten Daftar / List Item (Card Component)
Setiap baris/kartu pengajuan wajib menampilkan informasi berikut:
1. **Status Pengajuan (Badge Kiri Atas):** * `Draft` (Warna Abu-abu)
   * `Menunggu Persetujuan` (Warna Kuning)
   * `Disetujui` (Warna Hijau / "Published" seperti di gambar)
   * `Ditolak` (Warna Merah)
2. **Tanggal Pengajuan (Kiri Atas - Sejajar Status):** Menampilkan tanggal dan tahun saat pengajuan dibuat (Contoh: `24 Jun 2026`).
3. **Author (Kiri Bawah):** Nama staf atau user yang membuat pengajuan (Contoh: `Oleh: Budi (Barista)`).
4. **Total Item (Sisi Kanan):** Jumlah variasi bahan yang diajukan dalam satu dokumen (Contoh: `5 Items` atau `Total: 12 Pcs`).

### D. Tombol Aksi Utama (Floating Action Button)
* **Bentuk:** Tombol bulat berwarna merah dengan ikon `+` di pojok kanan bawah.
* **Fungsi:** Mengarahkan pengguna ke halaman **Form Pengajuan Baru**.

---

## 4. Alur Pengguna & Spesifikasi Fungsional (User Flow & Functional Specs)

### A. Alur Melihat Daftar Pengajuan (Read)
1. Pengguna masuk ke menu "Pengajuan Stok Bahan".
2. Sistem menampilkan daftar pengajuan terbaru di bagian paling atas (diurutkan secara *descending* berdasarkan tanggal).
3. Pengguna dapat mengeklik salah satu kartu/list untuk melihat detail bahan apa saja yang diajukan.

### B. Alur Membuat Pengajuan Baru (Create)
1. Pengguna menekan tombol `+` (FAB).
2. Sistem membuka halaman formulir yang berisi:
   * Nama Bahan (Dropdown/Searchable list dari master data bahan).
   * Jumlah/Kuantitas yang dibutuhkan.
   * Catatan (Opsional).
3. Pengguna dapat menambah lebih dari satu jenis bahan dalam satu pengajuan (memperbarui jumlah **Total Item**).
4. Pengguna menekan tombol "Kirim", status otomatis berubah menjadi `Menunggu Persetujuan`.

---

## 5. Kebutuhan Non-Fungsional (Non-Functional Requirements)
* **Responsivitas:** Tampilan harus *mobile-friendly* (seperti pada gambar referensi) karena mayoritas diakses oleh staf di outlet menggunakan smartphone atau tablet.
* **Keamanan Akses:** * Staf (Barista/Gudang) hanya bisa membuat pengajuan dan melihat riwayat.
   * Manajer/Owner memiliki hak akses tambahan untuk menekan tombol "Setujui" atau "Tolak" pada halaman detail pengajuan.