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
    <meta charset="UTF-8">
    <title>Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 to-white p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-red-700">Laporan Peminjaman & Pengembalian</h1>
        
        <div class="overflow-auto">
            <table class="min-w-full border border-collapse">
                <thead>
                    <tr class="bg-red-100 text-red-800">
                        <th class="border px-4 py-2">Anggota</th>
                        <th class="border px-4 py-2">Buku</th>
                        <th class="border px-4 py-2">Tgl Pinjam</th>
                        <th class="border px-4 py-2">Tgl Kembali</th>
                        <th class="border px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
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
                    <tr class="hover:bg-red-50">
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['anggota']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['buku']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                        <td class="border px-4 py-2"><?= $row['tanggal_kembali'] ?: '-' ?></td>
                        <td class="border px-4 py-2">
                            <span class="<?= $row['status'] == 'kembali' ? 'text-green-600' : 'text-red-600 font-semibold' ?>">
                                <?= htmlspecialchars(ucfirst($row['status'])) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
