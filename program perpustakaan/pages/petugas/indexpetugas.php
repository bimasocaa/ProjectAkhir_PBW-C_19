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
    <title>Data Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 to-white p-8">
    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-red-700">Daftar Petugas</h1>
            <a href="tambahpetugas.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition">
                + Tambah Petugas
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full text-sm text-left border border-gray-300">
                <thead class="bg-red-100 text-red-800">
                    <tr>
                        <th class="px-4 py-3 border">Nama</th>
                        <th class="px-4 py-3 border">Username</th>
                        <th class="px-4 py-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php
                    $sql = "SELECT * FROM petugas";
                    $result = $koneksi->query($sql);
                    while ($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-red-50 border-t">
                        <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama_petugas']); ?></td>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($row['username']); ?></td>
                        <td class="px-4 py-2 border text-center space-x-2">
                            <a href="editpetugas.php?id=<?= $row['id_petugas'] ?>" class="text-blue-600 hover:underline">Edit</a>
                            |
                            <a href="hapuspetugas.php?id=<?= $row['id_petugas'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-500">Belum ada data petugas.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
