document.addEventListener('DOMContentLoaded', () => {
  // Buka modal
  document.querySelectorAll('.openModal').forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.dataset.target;
      const modal = document.getElementById(targetId);
      if (modal) {
        modal.classList.remove('hidden');
      } else {
        console.warn(`Modal dengan ID "${targetId}" tidak ditemukan`);
      }
    });
  });

  // Tutup modal (pakai event delegation)
  document.addEventListener('click', (e) => {
    const closeBtn = e.target.closest('.closeModal');
    const modal = e.target.closest('.fixed[role="dialog"]');

    // Kalau tombol close ditekan
    if (closeBtn && modal) {
      modal.classList.add('hidden');
    }

    // Klik di area overlay (di luar konten modal)
    if (e.target.classList.contains('fixed') && e.target.getAttribute('role') === 'dialog') {
      e.target.classList.add('hidden');
    }
  });

  // Tutup modal dengan Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.fixed[role="dialog"]:not(.hidden)')
        .forEach(m => m.classList.add('hidden'));
    }
  });
});
