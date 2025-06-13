<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php';

$id = intval($_GET['id']);
$result = $koneksi->query("SELECT * FROM peminjaman WHERE id_peminjaman = $id");
if ($result->num_rows != 1) {
    header("Location: indexpeminjaman.php");
    exit;
}
$peminjaman = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = $_POST['status'];

    $sql = "
        UPDATE peminjaman 
        SET id_anggota='$id_anggota', id_buku='$id_buku', tanggal_pinjam='$tanggal_pinjam', tanggal_kembali='$tanggal_kembali', status='$status' 
        WHERE id_peminjaman = $id
    ";

    if ($koneksi->query($sql)) {
        header("Location: indexpeminjaman.php");
        exit;
    } else {
        $error = "Gagal update peminjaman: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-white flex items-center justify-center px-4">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-xl">
        <h1 class="text-3xl font-bold text-green-700 mb-6 text-center">Edit Data Peminjaman</h1>

        <?php if (isset($error)) echo "<p class='text-red-500 mb-4 text-center font-medium'>$error</p>"; ?>

        <form method="post" class="space-y-5">
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Anggota</label>
                <select name="id_anggota" required class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-300">
                    <?php
                    $res = $koneksi->query("SELECT * FROM anggota");
                    while ($a = $res->fetch_assoc()) {
                        $selected = ($a['id_anggota'] == $peminjaman['id_anggota']) ? 'selected' : '';
                        echo "<option value='{$a['id_anggota']}' $selected>{$a['nama']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label class="block mb-1 text-gray-700 font-medium">Buku</label>
                <select name="id_buku" required class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-300">
                    <?php
                    $res = $koneksi->query("SELECT * FROM buku");
                    while ($b = $res->fetch_assoc()) {
                        $selected = ($b['id_buku'] == $peminjaman['id_buku']) ? 'selected' : '';
                        echo "<option value='{$b['id_buku']}' $selected>{$b['judul']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="<?= $peminjaman['tanggal_pinjam'] ?>" required class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-300" />
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" value="<?= $peminjaman['tanggal_kembali'] ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-300" />
                </div>
            </div>

            <div>
                <label class="block mb-1 text-gray-700 font-medium">Status</label>
                <select name="status" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="dipinjam" <?= $peminjaman['status'] == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                    <option value="kembali" <?= $peminjaman['status'] == 'kembali' ? 'selected' : '' ?>>Kembali</option>
                </select>
            </div>

            <div class="pt-4 flex justify-between items-center">
                <a href="indexpeminjaman.php" class="text-gray-600 hover:underline">← Batal</a>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>
