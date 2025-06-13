<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

// Ambil data pengarang dan penerbit
$pengarang_result = $koneksi->query("SELECT id_pengarang, nama_pengarang FROM pengarang ORDER BY nama_pengarang ASC");
$penerbit_result = $koneksi->query("SELECT id_penerbit, nama_penerbit FROM penerbit ORDER BY nama_penerbit ASC");

if (!$pengarang_result) {
    die("Error mengambil data pengarang: " . $koneksi->error);
}
if (!$penerbit_result) {
    die("Error mengambil data penerbit: " . $koneksi->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $koneksi->real_escape_string($_POST['judul']);
    $tahun_terbit = intval($_POST['tahun_terbit']);
    $jumlah = intval($_POST['jumlah']);
    $isbn = $koneksi->real_escape_string($_POST['isbn']);
    $id_pengarang = intval($_POST['id_pengarang']);
    $id_penerbit = intval($_POST['id_penerbit']);

    $sql = "INSERT INTO buku (judul, tahun_terbit, jumlah, isbn, id_pengarang, id_penerbit)
            VALUES ('$judul', $tahun_terbit, $jumlah, '$isbn', $id_pengarang, $id_penerbit)";
    
    if ($koneksi->query($sql)) {
        header("Location: indexbuku.php");
        exit;
    } else {
        $error = "Gagal menambah buku: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-100 via-white to-blue-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-10 rounded-2xl shadow-2xl ring-1 ring-blue-200">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">📘 Tambah Data Buku</h1>

        <?php if (isset($error)) echo "<p class='text-red-600 font-semibold mb-4'>$error</p>"; ?>

        <form method="post" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Judul Buku</label>
                <input type="text" name="judul" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm" />
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm" />
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Jumlah Buku</label>
                <input type="number" name="jumlah" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm" />
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">ISBN</label>
                <input type="text" name="isbn" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm" />
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Pengarang</label>
                <select name="id_pengarang" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm bg-white">
                    <option value="">-- Pilih Pengarang --</option>
                    <?php while ($row = $pengarang_result->fetch_assoc()): ?>
                        <option value="<?= $row['id_pengarang'] ?>"><?= htmlspecialchars($row['nama_pengarang']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Penerbit</label>
                <select name="id_penerbit" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm bg-white">
                    <option value="">-- Pilih Penerbit --</option>
                    <?php while ($row = $penerbit_result->fetch_assoc()): ?>
                        <option value="<?= $row['id_penerbit'] ?>"><?= htmlspecialchars($row['nama_penerbit']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="flex justify-between pt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300">
                    💾 Simpan
                </button>
                <a href="indexbuku.php" class="text-blue-600 hover:underline hover:text-blue-800 font-medium">⏪ Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
