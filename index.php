<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>SMK TI Bali Global Denpasar</title>
  <link rel="stylesheet" href="src/output.css">
</head>
<body class="min-h-screen flex flex-col bg-gray-100 text-[#0b2340] font-sans">
  <!-- Hero -->
  <header class="bg-gradient-to-r from-[#0b63d6] via-[#0a4ea2] to-[#06306b] text-white py-12">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h1 class="text-3xl md:text-4xl font-semibold">SMK TI Bali Global Denpasar</h1>
      <p class="mt-2 text-lg md:text-base opacity-95">Website Manajemen Data Sekolah</p>
    </div>
  </header>
  
  <!-- Dark nav strip -->
  <nav class="bg-[#062743] shadow-inner">
    <div class="max-w-6xl mx-auto px-4">
      <ul class="flex justify-center space-x-12 py-3">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <li><a href="login/" class="text-sky-100 hover:text-white font-semibold py-2 px-3 border-b-2 border-transparent hover:border-[#0b63d6]">Login</a></li>
        <?php else: ?>
          <li><a href="logout/" class="text-sky-100 hover:text-white font-semibold py-2 px-3 border-b-2 border-transparent hover:border-red-500">Logout</a></li>
          <li><a href="/" class="text-sky-100 hover:text-white font-semibold py-2 px-3 border-b-2 border-transparent hover:border-red-500">Settings</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <!-- Main -->
  <main class="flex-1 py-10">
    <div class="max-w-6xl mx-auto px-4">
      <div class="min-h-[420px] flex items-center justify-center bg-transparent">
        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Dashboard Section -->
          <div class="text-center">
            <h2 class="text-2xl font-semibold mb-4">Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p class="text-lg mb-6">Anda sekarang berada di halaman dashboard manajemen data sekolah.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
              <a href="siswa/" class="bg-white shadow hover:shadow-lg rounded-xl p-6 border border-gray-200">
                <h3 class="font-semibold text-lg text-[#0b2340]">Kelola Data Siswa</h3>
              </a>
              <a href="guru/" class="bg-white shadow hover:shadow-lg rounded-xl p-6 border border-gray-200">
                <h3 class="font-semibold text-lg text-[#0b2340]">Kelola Data Guru</h3>
              </a>
              <a href="jurusan/" class="bg-white shadow hover:shadow-lg rounded-xl p-6 border border-gray-200">
                <h3 class="font-semibold text-lg text-[#0b2340]">Kelola Data Jurusan</h3>
              </a>
            </div>
          </div>
        <?php else: ?>
          <!-- Public Message -->
          <div class="text-center">
            <h2 class="text-2xl font-semibold mb-4">Welcome to the School Data Management System</h2>
            <p class="text-lg">Please login to use the management system.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>
  
  <!-- Footer -->
  <footer class="bg-[#0552b8] text-white py-3">
    <div class="max-w-6xl mx-auto px-4 text-center">
      &copy; <?= date('Y') ?> Database Siswa | SMK TI Bali Global Denpasar
    </div>
  </footer>
</body>
</html>
