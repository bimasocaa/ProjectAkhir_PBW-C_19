<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

// Pastikan ada ID peminjaman
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

// Ambil data peminjaman untuk cek status & buku
$q = "SELECT * FROM peminjaman WHERE id_peminjaman = $id";
$result = $koneksi->query($q);

if ($result->num_rows != 1) {
    header("Location: indexpeminjaman.php");
    exit;
}

$data = $result->fetch_assoc();

// Jika status masih 'dipinjam', lakukan update
if ($data['status'] == 'dipinjam') {
    $tanggalKembali = date('Y-m-d');

    // 1. Update status peminjaman
    $update = "UPDATE peminjaman 
               SET status = 'kembali', tanggal_kembali = '$tanggalKembali' 
               WHERE id_peminjaman = $id";
    $koneksi->query($update);

    // 2. Tambahkan stok buku kembali
    $updateStok = "UPDATE buku SET jumlah = jumlah + 1 WHERE id_buku = {$data['id_buku']}";
    $koneksi->query($updateStok);
}

header("Location: indexpeminjaman.php");
exit;
?>
