<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

// Cek apakah parameter ID tersedia
if (!isset($_GET['id'])) {
    header("Location: indexpetugas.php");
    exit;
}

$id = intval($_GET['id']);

// Hapus petugas berdasarkan ID
$hapus = "DELETE FROM petugas WHERE id_petugas = $id";
$koneksi->query($hapus);

// Kembali ke halaman daftar petugas
header("Location: indexpetugas.php");
exit;
?>
