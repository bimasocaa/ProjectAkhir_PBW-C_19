<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

$id = intval($_GET['id']);
$sql = "SELECT * FROM anggota WHERE id_anggota = $id";
$result = $koneksi->query($sql);
if ($result->num_rows != 1) {
    header("Location: indexanggota.php");
    exit;
}
$anggota = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $alamat = $koneksi->real_escape_string($_POST['alamat']);
    $telepon = $koneksi->real_escape_string($_POST['telepon']);
    $email = $koneksi->real_escape_string($_POST['email']);

    $sql = "UPDATE anggota SET nama='$nama', alamat='$alamat', telepon='$telepon', email='$email' WHERE id_anggota=$id";
    if ($koneksi->query($sql)) {
        header("Location: indexanggota.php");
        exit;
    } else {
        $error = "Gagal update anggota: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Edit Anggota</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-50 to-white p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-orange-700">Edit Anggota</h1>

        <?php if (isset($error)): ?>
            <p class="mb-4 text-red-600"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label class="block mb-1 font-semibold">Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($anggota['nama']) ?>" required class="w-full p-2 border rounded" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">Alamat</label>
                <textarea name="alamat" required class="w-full p-2 border rounded"><?= htmlspecialchars($anggota['alamat']) ?></textarea>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Telepon</label>
                <input type="text" name="telepon" value="<?= htmlspecialchars($anggota['telepon']) ?>" required class="w-full p-2 border rounded" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($anggota['email']) ?>" required class="w-full p-2 border rounded" />
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 transition">Simpan</button>
                <a href="indexanggota.php" class="text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
