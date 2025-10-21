<?php
// include component using correct relative path
$comp = __DIR__ . '/../components/form.php';
if (file_exists($comp)) {
    include_once $comp;
} else {
    // minimal fallback to avoid fatal error
    echo "<!doctype html><html><body><p class='p-4 text-red-700'>Component not found: components/form.php</p></body></html>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reusable Modal Tailwind + PHP</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">

  <!-- Tombol buka modal -->
  <button data-target="userModal" class="openModal px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
    Tambah User
  </button>

  <?php
  // pastikan fungsi tersedia sebelum dipanggil
  if (function_exists('renderModal')) {
    renderModal(
      id: 'userModal',
      title: 'Tambah User',
      action: 'submit_user.php',
      fields: [
        ['name' => 'username', 'type' => 'text', 'label' => 'Username'],
        ['name' => 'email', 'type' => 'email', 'label' => 'Email'],
        ['name' => 'password', 'type' => 'password', 'label' => 'Password']
      ]
    );
  } else {
    echo "<p class='mt-4 text-red-600'>renderModal() tidak tersedia.</p>";
  }
  ?>

  <script>
    // Buka modal
    document.querySelectorAll('.openModal').forEach(btn => {
      btn.addEventListener('click', () => {
        const target = document.getElementById(btn.dataset.target);
        if (target) target.classList.remove('hidden');
      });
    });

    // Tutup modal (delegated for dynamic elements)
    document.addEventListener('click', (e) => {
      if (e.target.matches('.closeModal') || e.target.closest('.closeModal')) {
        const modal = e.target.closest('.fixed');
        if (modal) modal.classList.add('hidden');
      }
      // overlay click closes
      if (e.target.classList && e.target.classList.contains('fixed') && !e.target.classList.contains('hidden')) {
        e.target.classList.add('hidden');
      }
    });

    // Esc closes
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        document.querySelectorAll('.fixed[role="dialog"]').forEach(m => m.classList.add('hidden'));
      }
    });
  </script>

</body>
</html>
