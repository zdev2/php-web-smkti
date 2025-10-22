<?php
function renderTable($table, $columns, $title = '') {
    global $conn;

    $query = "SELECT * FROM $table";
    $result = $conn->query($query);

    echo '<div class="p-6">';
    echo "<h2 class='text-xl font-bold mb-4'>$title</h2>";

    echo '<table class="min-w-full bg-white border border-gray-200 rounded-xl overflow-hidden shadow">';
    echo '<thead class="bg-gray-100 text-left">';
    echo '<tr>';
    foreach ($columns as $col) {
        echo "<th class='px-4 py-2 font-medium text-gray-700'>" . ucfirst($col) . "</th>";
    }
    echo "<th class='px-4 py-2 font-medium text-gray-700 text-center'>Action</th>";
    echo '</tr></thead><tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr class="border-t">';
        foreach ($columns as $col) {
            echo "<td class='px-4 py-2 text-gray-800'>" . htmlspecialchars($row[$col]) . "</td>";
        }

        echo "<td class='px-4 py-2 text-center'>
                <button class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 openEditModal' data-id='{$row['id']}'>Edit</button>
                <a href='delete.php?id={$row['id']}' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 ml-2'>Delete</a>
              </td>";
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}
?>
