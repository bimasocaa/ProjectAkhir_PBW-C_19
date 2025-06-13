<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php';

// Hitung sirkulasi yang sedang berjalan (jika belum dikembalikan)
$sirkulasi = $koneksi->query("SELECT COUNT(*) AS total FROM peminjaman WHERE tanggal_kembali IS NULL OR tanggal_kembali = ''");
if (!$sirkulasi) {
    die("Query gagal: " . $koneksi->error);
}
$dataSirkulasi = $sirkulasi->fetch_assoc();
$jumlahSirkulasi = $dataSirkulasi['total'];
?>




<!DOCTYPE html>
<html>
<head>
    <title>Data Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-white p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-green-700">Data Peminjaman</h1>
            <a href="tambahpeminjaman.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition">+ Tambah Peminjaman</a>
        </div>

        <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
            <table class="min-w-full text-sm text-left border border-gray-200">
                <thead class="bg-green-100 text-green-800 font-semibold">
                    <tr>
                        <th class="px-4 py-3 border">Anggota</th>
                        <th class="px-4 py-3 border">Buku</th>
                        <th class="px-4 py-3 border">Tanggal Pinjam</th>
                        <th class="px-4 py-3 border">Tanggal Kembali</th>
                        <th class="px-4 py-3 border">Status</th>
                        <th class="px-4 py-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php
                    $q = "
                        SELECT p.*, a.nama AS anggota, b.judul AS buku 
                        FROM peminjaman p
                        JOIN anggota a ON p.id_anggota = a.id_anggota
                        JOIN buku b ON p.id_buku = b.id_buku
                    ";
                    $result = $koneksi->query($q);
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <tr class="hover:bg-gray-50 border-t">
                        <td class="px-4 py-3 border"><?= htmlspecialchars($row['anggota']) ?></td>
                        <td class="px-4 py-3 border"><?= htmlspecialchars($row['buku']) ?></td>
                        <td class="px-4 py-3 border"><?= $row['tanggal_pinjam'] ?></td>
                        <td class="px-4 py-3 border"><?= $row['tanggal_kembali'] ?></td>
                        <td class="px-4 py-3 border">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                                <?= $row['status'] == 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 border text-center space-x-2">
                            <?php if ($row['status'] == 'dipinjam'): ?>
                                <a href="kembalipeminjaman.php?id=<?= $row['id_peminjaman'] ?>" class="text-green-600 hover:underline">Kembalikan</a>
                            <?php else: ?>
                                <span class="text-gray-400">Selesai</span>
                            <?php endif; ?>
                            |
                            <a href="editpeminjaman.php?id=<?= $row['id_peminjaman'] ?>" class="text-blue-600 hover:underline">Edit</a>
                            |
                            <a href="hapuspeminjaman.php?id=<?= $row['id_peminjaman'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">Belum ada data peminjaman.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
