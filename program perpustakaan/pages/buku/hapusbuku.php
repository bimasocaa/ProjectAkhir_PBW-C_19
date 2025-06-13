<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';  // Perhatikan path yang benar, dua folder ke atas

if (!isset($_GET['id'])) {
    header("Location: indexbuku.php");
    exit;
}

$id = intval($_GET['id']);

$sql = "DELETE FROM buku WHERE id_buku = $id";
if ($koneksi->query($sql)) {
    header("Location: indexbuku.php");
    exit;
} else {
    echo "Gagal hapus data: " . $koneksi->error;
}
?>
