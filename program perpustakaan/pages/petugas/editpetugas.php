<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

$id = intval($_GET['id']);
$sql = "SELECT * FROM petugas WHERE id_petugas = $id";
$result = $koneksi->query($sql);
if ($result->num_rows != 1) {
    header("Location: indexpetugas.php");
    exit;
}
$petugas = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_petugas = $koneksi->real_escape_string($_POST['nama_petugas']);
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Update password hanya jika diisi
    if (!empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE petugas SET nama_petugas='$nama_petugas', username='$username', password='$password_hashed' WHERE id_petugas=$id";
    } else {
        $sql = "UPDATE petugas SET nama_petugas='$nama_petugas', username='$username' WHERE id_petugas=$id";
    }

    if ($koneksi->query($sql)) {
        header("Location: indexpetugas.php");
        exit;
    } else {
        $error = "Gagal update petugas: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-bold text-red-700 mb-6 text-center">Edit Petugas</h1>

        <?php if (isset($error)) echo "<p class='text-red-600 mb-4 text-sm text-center'>$error</p>"; ?>

        <form method="post" class="space-y-5">
            <div>
                <label class="block text-gray-700 mb-1">Nama Petugas</label>
                <input type="text" name="nama_petugas" value="<?= htmlspecialchars($petugas['nama_petugas']) ?>" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($petugas['username']) ?>" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Password <small class="text-gray-500">(kosongkan jika tidak ingin ganti)</small></label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded shadow transition duration-200">Simpan</button>
                <a href="indexpetugas.php" class="text-red-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
