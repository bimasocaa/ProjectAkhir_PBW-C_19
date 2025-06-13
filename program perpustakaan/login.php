<?php
session_start();
include 'config/koneksi.php';

$error = '';
$success = '';

// PROSES REGISTRASI
if (isset($_POST['register'])) {
    $username = $_POST['reg_username'];
    $password = $_POST['reg_password'];

    $cek = $koneksi->prepare("SELECT * FROM login WHERE username = ?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        $role = 'user';
        $stmt = $koneksi->prepare("INSERT INTO login (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        if ($stmt->execute()) {
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            $error = "Registrasi gagal!";
        }
        $stmt->close();
    }
    $cek->close();
}

// PROSES LOGIN
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT * FROM login WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $data = $res->fetch_assoc();
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login & Register - E-Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f');">
  <!-- Overlay -->
  <div class="absolute inset-0 bg-black bg-opacity-50"></div>

  <!-- Card Form -->
  <div class="relative z-10 flex items-center justify-center min-h-screen">
  <div class="bg-white bg-opacity-80 backdrop-blur-md p-10 rounded-xl shadow-xl max-w-xl w-full space-y-6 border border-yellow-800">
    <!-- Header -->
    <div class="text-center">
      <img src="https://cdn-icons-png.flaticon.com/512/2965/2965878.png" alt="Logo Perpustakaan" class="mx-auto h-14">
      <h1 class="text-3xl font-bold text-yellow-900 mt-2">Perpustakaan Universitas</h1>
      <p class="text-gray-700 text-sm italic">Sistem Informasi E-Library Digital</p>
    </div>

    <!-- Alert -->
    <?php if ($error): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded"><?= $success ?></div>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="flex justify-center space-x-4">
      <button onclick="showForm('login')" id="btnLogin" class="tab-button px-4 py-2 rounded font-medium bg-yellow-700 text-white">Login</button>
      <button onclick="showForm('register')" id="btnRegister" class="tab-button px-4 py-2 rounded font-medium bg-gray-200 text-gray-800">Register</button>
    </div>

    <!-- Login Form -->
    <form method="POST" id="loginForm">
      <input type="text" name="username" placeholder="Username" required class="w-full mb-3 p-3 border border-yellow-300 rounded bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-yellow-700">
      <input type="password" name="password" placeholder="Password" required class="w-full mb-4 p-3 border border-yellow-300 rounded bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-yellow-700">
      <button type="submit" name="login" class="w-full bg-yellow-700 text-white py-2 rounded hover:bg-yellow-800 font-semibold transition">Masuk</button>
    </form>

    <!-- Register Form -->
    <form method="POST" id="registerForm" class="hidden">
      <input type="text" name="reg_username" placeholder="Username" required class="w-full mb-3 p-3 border border-yellow-300 rounded bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-yellow-700">
      <input type="password" name="reg_password" placeholder="Password" required class="w-full mb-4 p-3 border border-yellow-300 rounded bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-yellow-700">
      <button type="submit" name="register" class="w-full bg-green-700 text-white py-2 rounded hover:bg-green-800 font-semibold transition">Daftar</button>
    </form>
  </div>
</div>

<script>
  function showForm(form) {
    const loginBtn = document.getElementById('btnLogin');
    const registerBtn = document.getElementById('btnRegister');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (form === 'login') {
      loginForm.classList.remove('hidden');
      registerForm.classList.add('hidden');
      loginBtn.classList.add('bg-yellow-700', 'text-white');
      loginBtn.classList.remove('bg-gray-200', 'text-gray-800');
      registerBtn.classList.add('bg-gray-200', 'text-gray-800');
      registerBtn.classList.remove('bg-green-700', 'text-white');
    } else {
      loginForm.classList.add('hidden');
      registerForm.classList.remove('hidden');
      registerBtn.classList.add('bg-green-700', 'text-white');
      registerBtn.classList.remove('bg-gray-200', 'text-gray-800');
      loginBtn.classList.add('bg-gray-200', 'text-gray-800');
      loginBtn.classList.remove('bg-yellow-700', 'text-white');
    }
  }
</script>



</html>
