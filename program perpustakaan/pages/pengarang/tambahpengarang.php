<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama_pengarang']);
    $koneksi->query("INSERT INTO pengarang (nama_pengarang) VALUES ('$nama')");
    header("Location: indexpengarang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pengarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
    <h1 class="text-xl font-bold mb-4">Tambah Pengarang</h1>

    <form method="post" class="space-y-4 max-w-md">
        <div>
            <label>Nama Pengarang</label>
            <input type="text" name="nama_pengarang" required class="w-full p-2 border rounded" />
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="indexpengarang.php" class="ml-4 text-gray-600">Batal</a>
    </form>
</body>
</html>
