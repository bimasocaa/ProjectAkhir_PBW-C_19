<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pengarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Pengarang</h1>
    <a href="tambahpengarang.php" class="bg-green-500 text-white px-3 py-1 rounded">Tambah Pengarang</a>
    <table class="table-auto w-full mt-4 border border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Nama Pengarang</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $koneksi->query("SELECT * FROM pengarang");
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_pengarang']) ?></td>
                <td class="border px-4 py-2">
                    <a href="editpengarang.php?id=<?= $row['id_pengarang'] ?>" class="text-blue-500">Edit</a> |
                    <a href="hapuspengarang.php?id=<?= $row['id_pengarang'] ?>" class="text-red-500" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
