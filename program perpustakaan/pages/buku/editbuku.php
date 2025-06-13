<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: indexbuku.php");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM buku WHERE id_buku = $id";
$result = $koneksi->query($sql);
if ($result->num_rows != 1) {
    header("Location: indexbuku.php");
    exit;
}
$buku = $result->fetch_assoc();

$pengarangResult = $koneksi->query("SELECT id_pengarang, nama_pengarang FROM pengarang ORDER BY nama_pengarang ASC");
$penerbitResult = $koneksi->query("SELECT id_penerbit, nama_penerbit FROM penerbit ORDER BY nama_penerbit ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $koneksi->real_escape_string($_POST['judul']);
    $tahun_terbit = intval($_POST['tahun_terbit']);
    $jumlah = intval($_POST['jumlah']);
    $isbn = $koneksi->real_escape_string($_POST['isbn']);
    $id_pengarang = intval($_POST['id_pengarang']);
    $id_penerbit = intval($_POST['id_penerbit']);

    $sqlUpdate = "UPDATE buku SET 
        judul='$judul',
        tahun_terbit=$tahun_terbit,
        jumlah=$jumlah,
        isbn='$isbn',
        id_pengarang=$id_pengarang,
        id_penerbit=$id_penerbit
        WHERE id_buku=$id";

    if ($koneksi->query($sqlUpdate)) {
        header("Location: indexbuku.php");
        exit;
    } else {
        $error = "Gagal update buku: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Edit Buku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-white p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-blue-700 mb-6">Edit Buku</h1>

        <?php if (isset($error)): ?>
            <p class="mb-4 text-red-600 font-medium"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul</label>
                <input type="text" name="judul" required class="w-full p-2 border border-gray-300 rounded" value="<?= htmlspecialchars($buku['judul']) ?>" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" required class="w-full p-2 border border-gray-300 rounded" value="<?= htmlspecialchars($buku['tahun_terbit']) ?>" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="jumlah" required class="w-full p-2 border border-gray-300 rounded" value="<?= htmlspecialchars($buku['jumlah']) ?>" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">ISBN</label>
                <input type="text" name="isbn" required class="w-full p-2 border border-gray-300 rounded" value="<?= htmlspecialchars($buku['isbn']) ?>" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pengarang</label>
                <select name="id_pengarang" required class="w-full p-2 border border-gray-300 rounded">
                    <option value="">-- Pilih Pengarang --</option>
                    <?php while ($row = $pengarangResult->fetch_assoc()): ?>
                        <option value="<?= $row['id_pengarang'] ?>" <?= $buku['id_pengarang'] == $row['id_pengarang'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['nama_pengarang']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Penerbit</label>
                <select name="id_penerbit" required class="w-full p-2 border border-gray-300 rounded">
                    <option value="">-- Pilih Penerbit --</option>
                    <?php while ($row = $penerbitResult->fetch_assoc()): ?>
                        <option value="<?= $row['id_penerbit'] ?>" <?= $buku['id_penerbit'] == $row['id_penerbit'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['nama_penerbit']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                        Simpan Perubahan
                </button>
                <a href="indexbuku.php" class="text-gray-600 hover:text-blue-700 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
