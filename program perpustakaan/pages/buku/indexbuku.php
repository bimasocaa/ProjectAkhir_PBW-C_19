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
    <title>Data Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-100 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Heading -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-extrabold text-blue-800">📚 Daftar Buku</h1>
            <a href="tambahbuku.php" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-5 py-2 rounded-lg font-semibold shadow-md transition duration-300">
                + Tambah Buku
            </a>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto shadow-xl rounded-2xl bg-white ring-1 ring-gray-200">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-blue-100 text-blue-800 font-semibold text-sm">
                    <tr>
                        <th class="px-5 py-3">Judul</th>
                        <th class="px-5 py-3">Tahun</th>
                        <th class="px-5 py-3">Jumlah</th>
                        <th class="px-5 py-3">ISBN</th>
                        <th class="px-5 py-3">Pengarang</th>
                        <th class="px-5 py-3">Penerbit</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 text-sm divide-y divide-gray-200">
                    <?php
                    $sql = "SELECT buku.*, pengarang.nama_pengarang, penerbit.nama_penerbit 
                            FROM buku 
                            JOIN pengarang ON buku.id_pengarang = pengarang.id_pengarang
                            JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit";
                    $result = $koneksi->query($sql);

                    while ($row = $result->fetch_assoc()):
                        // warna badge berdasarkan jumlah buku
                        $jumlah = $row['jumlah_buku'];
                        $badgeColor = $jumlah >= 30 ? 'bg-green-100 text-green-700' : ($jumlah >= 20 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                    ?>
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-5 py-3"><?= htmlspecialchars($row['judul']) ?></td>
                        <td class="px-5 py-3"><?= $row['tahun_terbit'] ?></td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium <?= $badgeColor ?>">
                                <?= $jumlah ?> buku
                            </span>
                        </td>
                        <td class="px-5 py-3"><?= htmlspecialchars($row['isbn']) ?></td>
                        <td class="px-5 py-3"><?= htmlspecialchars($row['nama_pengarang']) ?></td>
                        <td class="px-5 py-3"><?= htmlspecialchars($row['nama_penerbit']) ?></td>
                        <td class="px-5 py-3 text-center space-x-2">
                            <a href="editbuku.php?id=<?= $row['id_buku'] ?>" class="text-indigo-600 hover:underline font-medium">Edit</a>
                            <a href="hapusbuku.php?id=<?= $row['id_buku'] ?>" class="text-red-500 hover:underline font-medium" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>

                    <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">📭 Belum ada data buku.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
