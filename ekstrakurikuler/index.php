<?php
session_start();
require_once __DIR__ . '/../connect.php';
require_once __DIR__ . '/../components/table.php';
require_once __DIR__ . '/../components/form.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Ekstrakurikuler - SMK TI Bali Global</title>
  <link rel="stylesheet" href="../public/output.css">
</head>
<body class="min-h-screen flex flex-col bg-gray-100 text-[#0b2340] font-sans">
  <header class="bg-gradient-to-r from-[#0b63d6] via-[#0a4ea2] to-[#06306b] text-white py-12">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h1 class="text-3xl md:text-4xl font-semibold">Ekstrakurikuler</h1>
    </div>
  </header>

  <nav class="bg-[#062743] shadow-inner">
    <div class="max-w-6xl mx-auto px-4 py-3">
    </div>
  </nav>

  <main class="flex-1 py-10">
    <div class="max-w-6xl mx-auto px-4">
      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="mb-4">
          <button data-target="insertEkstraModal" class="openModal px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Tambah Ekstrakurikuler</button>
        </div>

        <?php
          // modal for add — gunakan nama kolom sesuai connect.php
          if (function_exists('renderModal')) {
              renderModal(
                  id: 'insertEkstraModal',
                  table: 'ekstrakurikuler',
                  title: 'Tambah Ekstrakurikuler',
                  action: '../components/insert.php',
                  fields: [
                      ['name' => 'nama_ekstra', 'type' => 'text', 'label' => 'Nama Ekstrakurikuler'],
                      ['name' => 'jadwal', 'type' => 'text', 'label' => 'Jadwal'],
                      ['name' => 'guru_ekstra', 'type' => 'text', 'label' => 'Guru Pengampu'],
                  ]
              );
          }

          // table — gunakan kolom yang sama seperti tabel DB
          renderTable('ekstrakurikuler', ['id','nama_ekstra','jadwal','guru_ekstra'], 'Daftar Ekstrakurikuler');
        ?>

        <script src="../public/modal.js"></script>
      <?php else: ?>
        <div class="text-center py-12">
          <p class="text-lg">Silakan login untuk mengelola data ekstrakurikuler.</p>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <footer class="bg-[#0552b8] text-white py-3">
    <div class="max-w-6xl mx-auto px-4 text-center">&copy; <?= date('Y') ?> SMK TI Bali Global Denpasar</div>
  </footer>
</body>
</html>
