<?php
session_start();

// load dependencies early so functions/$conn are available
require_once __DIR__ . '/../connect.php';
require_once __DIR__ . '/../components/table.php';
require_once __DIR__ . '/../components/form.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>SMK TI Bali Global Denpasar</title>
  <link rel="stylesheet" href="../public/output.css">
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
          <li><a href="../login/" class="text-sky-100 hover:text-white font-semibold py-2 px-3 border-b-2 border-transparent hover:border-[#0b63d6]">Login</a></li>
        <?php else: ?>
          <li><a href="../logout/" class="text-sky-100 hover:text-white font-semibold py-2 px-3 border-b-2 border-transparent hover:border-red-500">Logout</a></li>
          <li><a href="../" class="text-sky-100 hover:text-white font-semibold py-2 px-3 border-b-2 border-transparent hover:border-red-500">Settings</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <!-- Main -->
  <main class="flex-1 py-10">
    <div class="max-w-6xl mx-auto px-4">
      <div class="min-h-[420px] bg-transparent">
        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Dashboard Section -->
          <button data-target="insertGuruModal" class="openModal px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Tambah Guru
          </button>

          <?php
            // use lowercase table name and ensure renderModal exists
            if (function_exists('renderModal')) {
                renderModal(
                    id: 'insertGuruModal',
                    table: 'guru',
                    title: 'Tambah Guru',
                    action: '../components/insert.php',
                    fields: [
                        ['name' => 'nip', 'type' => 'text', 'label' => 'NIP'],
                        ['name' => 'nama', 'type' => 'text', 'label' => 'Nama Guru'],
                        ['name' => 'mapel', 'type' => 'text', 'label' => 'Mata Pelajaran'],
                    ]
                );
            } else {
                echo '<p class="text-red-600 mt-4">Component renderModal() tidak tersedia.</p>';
            }

            // render the table
            renderTable('guru', ['id', 'nip', 'nama', 'mapel'], 'Guru');
          ?>

          <script src="../public/modal.js"></script>
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
