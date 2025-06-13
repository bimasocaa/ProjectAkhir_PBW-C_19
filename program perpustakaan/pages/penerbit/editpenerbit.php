<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php';

$id = intval($_GET['id']);
$result = $koneksi->query("SELECT * FROM penerbit WHERE id_penerbit = $id");
if ($result->num_rows != 1) {
    header("Location: indexpenerbit.php");
    exit;
}
$penerbit = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama_penerbit']);
    $alamat = $koneksi->real_escape_string($_POST['alamat']);
    $koneksi->query("UPDATE penerbit SET nama_penerbit = '$nama', alamat = '$alamat' WHERE id_penerbit = $id");
    header("Location: indexpenerit.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Penerbit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
    <h1 class="text-xl font-bold mb-4">Edit Penerbit</h1>

    <form method="post" class="space-y-4 max-w-md">
        <div>
            <label>Nama Penerbit</label>
            <input type="text" name="nama_penerbit" value="<?= htmlspecialchars($penerbit['nama_penerbit']) ?>" required class="w-full p-2 border rounded" />
        </div>
        <div>
            <label>Alamat</label>
            <textarea name="alamat" required class="w-full p-2 border rounded"><?= htmlspecialchars($penerbit['alamat']) ?></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="indexpenerbit.php" class="ml-4 text-gray-600">Batal</a>
    </form>
</body>
</html>
