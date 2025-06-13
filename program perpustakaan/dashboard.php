<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'config/koneksi.php';

$query1 = $koneksi->query("SELECT COUNT(*) as total FROM buku");
$total_buku = $query1 ? $query1->fetch_assoc()['total'] : 0;

$query2 = $koneksi->query("SELECT COUNT(*) as total FROM anggota");
$total_anggota = $query2 ? $query2->fetch_assoc()['total'] : 0;

$query3 = $koneksi->query("SELECT COUNT(*) as total FROM peminjaman WHERE status = 'dipinjam'");
$sirkulasi_berjalan = $query3 ? $query3->fetch_assoc()['total'] : 0;

$query4 = $koneksi->query("SELECT COUNT(*) as total FROM peminjaman WHERE tanggal_kembali IS NOT NULL AND tanggal_kembali != ''");
$total_laporan = $query4 ? $query4->fetch_assoc()['total'] : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - E-Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-yellow-50 text-gray-800 font-sans">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-yellow-900 text-white flex flex-col">
    <div class="flex items-center justify-center h-16 bg-yellow-700">
      <h1 class="text-xl font-bold">📚 E-Library</h1>
    </div>
    <div class="p-4 border-b border-yellow-800 text-center">
      <img src="Dasboard.jpg" alt="User" class="w-14 h-14 rounded-full mx-auto">
      <p class="mt-2 font-semibold"><?= htmlspecialchars($_SESSION['username']) ?></p>
      <p class="text-sm bg-yellow-400 text-black px-2 py-1 rounded mt-1">Administrator</p>
    </div>
    <nav class="flex-1 px-4 py-4 text-sm space-y-2">
      <a href="dashboard.php" class="block py-2 px-3 rounded bg-yellow-800 hover:bg-yellow-700"><i class="fas fa-home mr-2"></i>Dashboard</a>
      <a href="pages/buku/indexbuku.php" class="block py-2 px-3 rounded hover:bg-yellow-700"><i class="fas fa-book mr-2"></i>Kelola Buku</a>
      <a href="pages/anggota/indexanggota.php" class="block py-2 px-3 rounded hover:bg-yellow-700"><i class="fas fa-users mr-2"></i>Kelola Anggota</a>
      <a href="pages/peminjaman/indexpeminjaman.php" class="block py-2 px-3 rounded hover:bg-yellow-700"><i class="fas fa-sync-alt mr-2"></i>Sirkulasi</a>
      <a href="pages/laporan/indexlaporan.php" class="block py-2 px-3 rounded hover:bg-yellow-700"><i class="fas fa-file-alt mr-2"></i>Laporan</a>
      <div class="mt-6 border-t border-yellow-800 pt-4">
        <a href="pages/petugas/indexpetugas.php" class="block py-2 px-3 rounded hover:bg-yellow-700"><i class="fas fa-user-cog mr-2"></i>Pengguna Sistem</a>
        <a href="logout.php" class="block py-2 px-3 rounded hover:bg-yellow-700"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
      </div>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 px-8 py-6 relative overflow-hidden">
    <img src="assets/bg-ilustrasi.svg" alt="" class="absolute right-0 top-20 w-64 opacity-10 hidden lg:block pointer-events-none" />
    
    <div class="flex justify-between items-center mb-8">
      <div>
        <h2 class="text-2xl font-bold text-yellow-900">Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h2>
        <p class="text-sm text-yellow-700">Berikut ringkasan data terbaru dari sistem perpustakaan</p>
      </div>
      <span class="text-sm text-blue-500">📘 E-Library Sistem Informasi V1.0</span>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white p-5 rounded-lg border-l-4 border-yellow-500 shadow hover:shadow-md">
        <div class="flex items-center space-x-4">
          <i class="fas fa-book text-yellow-500 text-3xl"></i>
          <div>
            <p class="text-xl font-bold"><?= $total_buku ?></p>
            <p class="text-gray-600 text-sm">Total Buku</p>
            <a href="pages/buku/indexbuku.php" class="text-xs text-yellow-600 underline">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="bg-white p-5 rounded-lg border-l-4 border-orange-500 shadow hover:shadow-md">
        <div class="flex items-center space-x-4">
          <i class="fas fa-users text-orange-500 text-3xl"></i>
          <div>
            <p class="text-xl font-bold"><?= $total_anggota ?></p>
            <p class="text-gray-600 text-sm">Total Anggota</p>
            <a href="pages/anggota/indexanggota.php" class="text-xs text-orange-600 underline">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="bg-white p-5 rounded-lg border-l-4 border-teal-500 shadow hover:shadow-md">
        <div class="flex items-center space-x-4">
          <i class="fas fa-sync-alt text-teal-500 text-3xl"></i>
          <div>
            <p class="text-xl font-bold"><?= $sirkulasi_berjalan ?></p>
            <p class="text-gray-600 text-sm">Sedang Dipinjam</p>
            <a href="pages/peminjaman/indexpeminjaman.php" class="text-xs text-teal-600 underline">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="bg-white p-5 rounded-lg border-l-4 border-rose-500 shadow hover:shadow-md">
        <div class="flex items-center space-x-4">
          <i class="fas fa-file-alt text-rose-500 text-3xl"></i>
          <div>
            <p class="text-xl font-bold"><?= $total_laporan ?></p>
            <p class="text-gray-600 text-sm">Laporan Sirkulasi</p>
            <a href="pages/laporan/indexlaporan.php" class="text-xs text-rose-600 underline">Lihat Detail</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart -->
    <div class="mt-12 bg-white p-6 rounded-lg shadow">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">📊 Ringkasan Statistik</h3>
      <canvas id="grafikStatistik" height="100"></canvas>
    </div>
  </main>
</div>

<!-- Chart.js Script -->
<script>
  const ctx = document.getElementById('grafikStatistik').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Buku', 'Anggota', 'Dipinjam', 'Laporan'],
      datasets: [{
        label: 'Jumlah',
        data: [<?= $total_buku ?>, <?= $total_anggota ?>, <?= $sirkulasi_berjalan ?>, <?= $total_laporan ?>],
        backgroundColor: ['#facc15', '#fb923c', '#14b8a6', '#f43f5e']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      }
    }
  });
</script>

</body>
</html>
