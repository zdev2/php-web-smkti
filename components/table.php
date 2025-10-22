<?php
function renderTable($table, $columns, $title = '') {
    global $conn;

    $query = "SELECT * FROM `" . str_replace("`","``",$table) . "` WHERE deleted_at IS NULL";
    $result = $conn->query($query);

    if (!$result) {
        echo '<div class="p-6 text-red-600">Query failed: ' . htmlspecialchars($conn->error) . '</div>';
        return;
    }
    ?>
    <div class="p-6">
      <h2 class="text-xl font-bold mb-4"><?php echo htmlspecialchars($title); ?></h2>

      <table class="min-w-full bg-white border border-gray-200 rounded-xl overflow-hidden shadow">
        <thead class="bg-gray-100 text-left">
          <tr>
            <?php foreach ($columns as $col): ?>
              <th class="px-4 py-2 font-medium text-gray-700"><?php echo htmlspecialchars(ucfirst($col)); ?></th>
            <?php endforeach; ?>
            <th class="px-4 py-2 font-medium text-gray-700 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): 
              $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
          ?>
            <tr class="border-t">
              <?php foreach ($columns as $col): 
                  $cell = $row[$col] ?? '';
              ?>
                <td class="px-4 py-2 text-gray-800"><?php echo htmlspecialchars((string)$cell); ?></td>
              <?php endforeach; ?>

              <td class="px-4 py-2 text-center">
                <button
                  class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 openEditModal"
                  data-row="<?php echo $rowJson; ?>"
                  data-table="<?php echo htmlspecialchars($table); ?>">
                  Edit
                </button>

                <a href="delete.php?id=<?php echo urlencode($row['id']); ?>"
                   class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 ml-2">
                  Delete
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- single reusable edit modal -->
    <div id="editModal" class="fixed inset-0 z-50 bg-stone-950/50 bg-opacity-50 flex items-center justify-center" style="display:none;">
      <div class="bg-white rounded-2xl shadow-lg w-full max-w-lg mx-4 border border-gray-200 relative">
        <div class="p-6">
          <div class="mb-4 text-lg font-semibold text-[#0b2340]">Edit</div>

          <form id="editForm" method="post" action="../components/update.php" class="space-y-4">
            <input type="hidden" name="table" id="edit_table" value="<?php echo htmlspecialchars($table); ?>">
            <input type="hidden" name="id" id="edit_id" value="">
            <div id="editFields"></div>

            <div class="flex items-center justify-end gap-3 pt-2">
              <button type="button" id="editCancel" class="px-4 py-2 rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>
              <button type="submit" class="px-4 py-2 rounded-md bg-[#0b63d6] text-white hover:bg-[#094fb3]">Simpan</button>
            </div>
          </form>
        </div>

        <button type="button" id="editClose" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 p-1 rounded-full">✕</button>
      </div>
    </div>

    <script>
    (function(){
      const modal = document.getElementById('editModal');
      const fieldsContainer = document.getElementById('editFields');
      const editTable = document.getElementById('edit_table');
      const editId = document.getElementById('edit_id');

      function showModal(){ modal.style.display = 'flex'; }
      function hideModal(){ modal.style.display = 'none'; }

      document.querySelectorAll('.openEditModal').forEach(btn => {
        btn.addEventListener('click', function(){
          const row = JSON.parse(this.getAttribute('data-row'));
          const table = this.getAttribute('data-table') || '';
          editTable.value = table;
          editId.value = row.id ?? '';

          fieldsContainer.innerHTML = '';
          Object.keys(row).forEach(k => {
            if (['id','created_at','updated_at','deleted_at'].includes(k)) return;
            const val = row[k] ?? '';
            const wrapper = document.createElement('div');
            wrapper.className = 'mb-2';
            const label = document.createElement('label');
            label.className = 'block text-sm font-medium text-gray-700 mb-1';
            label.textContent = k.replace(/_/g, ' ');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = k;
            input.value = val;
            input.className = 'mt-1 block w-full rounded-md border border-gray-300 px-3 py-2';
            wrapper.appendChild(label);
            wrapper.appendChild(input);
            fieldsContainer.appendChild(wrapper);
          });

          showModal();
        });
      });

      document.getElementById('editCancel').addEventListener('click', hideModal);
      document.getElementById('editClose').addEventListener('click', hideModal);

      modal.addEventListener('click', function(e){
        if (e.target === this) hideModal();
      });
      document.addEventListener('keydown', function(e){ if (e.key === 'Escape') hideModal(); });
    })();
    </script>
    <?php
    $result->free();
}
?>
