<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php';

$id = intval($_GET['id']);
$result = $koneksi->query("SELECT * FROM pengarang WHERE id_pengarang = $id");
if ($result->num_rows != 1) {
    header("Location: indexpengarang.php");
    exit;
}
$pengarang = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama_pengarang']);
    $koneksi->query("UPDATE pengarang SET nama_pengarang = '$nama' WHERE id_pengarang = $id");
    header("Location: indexpengarang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
    <h1 class="text-xl font-bold mb-4">Edit Pengarang</h1>

    <form method="post" class="space-y-4 max-w-md">
        <div>
            <label>Nama Pengarang</label>
            <input type="text" name="nama_pengarang" value="<?= htmlspecialchars($pengarang['nama_pengarang']) ?>" required class="w-full p-2 border rounded" />
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="indexpengarang.php" class="ml-4 text-gray-600">Batal</a>
    </form>
</body>
</html>
