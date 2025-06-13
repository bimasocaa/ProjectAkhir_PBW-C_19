<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Data Anggota</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-50 to-white p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-orange-700">Daftar Anggota</h1>
            <a href="tambahanggota.php" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded shadow transition">+ Tambah Anggota</a>
        </div>

        <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
            <table class="min-w-full text-sm text-left border border-gray-200">
                <thead class="bg-orange-100 text-orange-800 font-semibold">
                    <tr>
                        <th class="px-4 py-3 border">Nama</th>
                        <th class="px-4 py-3 border">Alamat</th>
                        <th class="px-4 py-3 border">Telepon</th>
                        <th class="px-4 py-3 border">Email</th>
                        <th class="px-4 py-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php
                    $sql = "SELECT * FROM anggota";
                    $result = $koneksi->query($sql);
                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 border-t">
                                <td class="px-4 py-3 border"><?= htmlspecialchars($row['nama']); ?></td>
                                <td class="px-4 py-3 border"><?= htmlspecialchars($row['alamat']); ?></td>
                                <td class="px-4 py-3 border"><?= htmlspecialchars($row['telepon']); ?></td>
                                <td class="px-4 py-3 border"><?= htmlspecialchars($row['email']); ?></td>
                                <td class="px-4 py-3 border text-center space-x-2">
                                    <a href="editanggota.php?id=<?= $row['id_anggota'] ?>" class="text-blue-600 hover:underline">Edit</a> |
                                    <a href="hapusanggota.php?id=<?= $row['id_anggota'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data anggota.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
