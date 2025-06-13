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
    <title>Data Penerbit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Penerbit</h1>
    <a href="tambah.php" class="bg-green-500 text-white px-3 py-1 rounded">Tambah Penerbit</a>
    <table class="table-auto w-full mt-4 border border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Nama Penerbit</th>
                <th class="border px-4 py-2">Alamat</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $koneksi->query("SELECT * FROM penerbit");
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_penerbit']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($row['alamat']) ?></td>
                <td class="border px-4 py-2">
                    <a href="edit.php?id=<?= $row['id_penerbit'] ?>" class="text-blue-500">Edit</a> |
                    <a href="hapuspenerbit.php?id=<?= $row['id_penerbit'] ?>" class="text-red-500" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
