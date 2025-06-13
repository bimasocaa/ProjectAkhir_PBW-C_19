<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = intval($_POST['id_anggota']);
    $id_buku = intval($_POST['id_buku']);
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $status = 'dipinjam';

    $sql = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, status) 
            VALUES ($id_anggota, $id_buku, '$tanggal_pinjam', '$status')";

    if ($koneksi->query($sql)) {
        header("Location: indexpeminjaman.php");
        exit;
    } else {
        $error = "Gagal menyimpan data: " . $koneksi->error;
    }
}

// Ambil data anggota dan buku untuk form
$anggota = $koneksi->query("SELECT * FROM anggota");
$buku = $koneksi->query("SELECT * FROM buku");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white p-6 min-h-screen">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4 text-green-700">Tambah Peminjaman</h1>

        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-4"><?= $error ?></p>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label class="block">Anggota</label>
                <select name="id_anggota" required class="w-full border p-2 rounded">
                    <option value="">-- Pilih Anggota --</option>
                    <?php while ($a = $anggota->fetch_assoc()): ?>
                        <option value="<?= $a['id_anggota'] ?>"><?= htmlspecialchars($a['nama']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block">Buku</label>
                <select name="id_buku" required class="w-full border p-2 rounded">
                    <option value="">-- Pilih Buku --</option>
                    <?php while ($b = $buku->fetch_assoc()): ?>
                        <option value="<?= $b['id_buku'] ?>"><?= htmlspecialchars($b['judul']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" required class="w-full border p-2 rounded" />
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
            <a href="indexpeminjaman.php" class="ml-4 text-gray-600 hover:underline">Batal</a>
        </form>
    </div>
</body>
</html>
