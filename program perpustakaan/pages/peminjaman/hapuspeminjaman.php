<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php';

$id = intval($_GET['id']);
$koneksi->query("DELETE FROM peminjaman WHERE id_peminjaman = $id");

header("Location: indexpeminjaman.php");
exit;
?>
