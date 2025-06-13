<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php';

$id = intval($_GET['id']);
$koneksi->query("DELETE FROM penerbit WHERE id_penerbit = $id");
header("Location: indexpenerbit.php");
exit;
?>
