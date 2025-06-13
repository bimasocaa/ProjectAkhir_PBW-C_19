<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

$id = intval($_GET['id']);
$sql = "DELETE FROM anggota WHERE id_anggota = $id";
$koneksi->query($sql);

header("Location: indexanggota.php");
exit;
?>
