<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    $sql = "INSERT INTO petugas (nama_petugas, username, password) VALUES ('$nama', '$username', '$password')";

    if ($koneksi->query($sql)) {
        header("Location: indexpetugas.php");
        exit;
    } else {
        $error = "Gagal menambahkan petugas: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-white min-h-screen flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-red-700 mb-6 text-center">Tambah Petugas</h1>

        <?php if (isset($error)): ?>
            <p class="mb-4 text-red-600 text-sm bg-red-100 p-2 rounded"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-300" />
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700">Username</label>
                <input type="text" name="username" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-300" />
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-300" />
            </div>
            <div class="flex justify-between items-center">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">Simpan</button>
                <a href="indexpetugas.php" class="text-gray-600 hover:text-red-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
