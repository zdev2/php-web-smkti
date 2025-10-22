<?php
require_once '../connect.php';

function renderModal($id, $table, $title, $action, $fields = []) {
  ?>
  <div id="<?= htmlspecialchars($id) ?>" class="fixed inset-0 hidden z-50 bg-black bg-opacity-50 flex items-center justify-center" role="dialog" aria-modal="true" aria-labelledby="<?= htmlspecialchars($id) ?>-title" tabindex="-1">
    <div class="relative bg-white rounded-2xl shadow-lg w-full max-w-lg mx-4 border border-gray-200">
      <div class="p-6">
        <div id="<?= htmlspecialchars($id) ?>-title" class="mb-4 text-lg font-semibold text-[#0b2340]">
          <?= htmlspecialchars($title) ?>
        </div>

        <form id="<?= htmlspecialchars($id) ?>-form" method="POST" action="<?= htmlspecialchars($action) ?>" class="space-y-4">
          
          <?php foreach ($fields as $field): 
            $name  = htmlspecialchars($field['name'] ?? '');
            $type  = $field['type'] ?? 'text';
            $label = htmlspecialchars($field['label'] ?? ucfirst($name));
            $opts  = $field['options'] ?? null;
          ?>
            <div>
              <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
              <label for="<?= $name ?>" class="block text-sm font-medium text-gray-700 mb-1"><?= $label ?></label>

              <?php if ($opts && is_array($opts)): ?>
                <select id="<?= $name ?>" name="<?= $name ?>" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#0b63d6] focus:border-[#0b63d6]">
                  <option value=""><?= $field['placeholder'] ?? '-- Pilih --' ?></option>
                  <?php foreach ($opts as $val => $lab): ?>
                    <option value="<?= htmlspecialchars($val) ?>"><?= htmlspecialchars($lab) ?></option>
                  <?php endforeach; ?>
                </select>

              <?php elseif ($type === 'textarea'): ?>
                <textarea id="<?= $name ?>" name="<?= $name ?>" rows="4" required
                          class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0b63d6] focus:border-[#0b63d6]"></textarea>

              <?php else: ?>
                <input
                  type="<?= htmlspecialchars($type) ?>"
                  id="<?= $name ?>"
                  name="<?= $name ?>"
                  required
                  class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0b63d6] focus:border-[#0b63d6]"
                />
              <?php endif; ?>
            </div>
          <?php endforeach; ?>

          <div class="flex items-center justify-end gap-3 pt-2">
            <button type="button" class="closeModal px-4 py-2 rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>
            <button type="submit" class="px-4 py-2 rounded-md bg-[#0b63d6] text-white hover:bg-[#094fb3]">Simpan</button>
          </div>
        </form>
      </div>

      <button type="button" aria-label="Tutup" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 p-1 rounded-full closeModal">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
  </div>

  <script>
    (function(){
      const modal = document.getElementById('<?= addslashes($id) ?>');
      if (!modal) return;

      // close buttons
      modal.querySelectorAll('.closeModal').forEach(btn => {
        btn.addEventListener('click', () => modal.classList.add('hidden'));
      });

      // overlay click closes
      modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
      });

      // Esc closes
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) modal.classList.add('hidden');
      });
    })();
  </script>
  <?php
}
?>
