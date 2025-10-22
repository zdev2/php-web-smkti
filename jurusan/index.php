<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/output.css">
    <title>Document</title>
</head>
<body>
    <button data-target="insertJurusanModal" class="openModal px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        Tambah User
    </button>
    <?php
        require_once '../connect.php';
        require_once '../components/table.php';
        require_once '../components/form.php';
        renderModal(
            id: 'insertJurusanModal',
            table: 'jurusan',
            title: 'Tambah Jurusan',
            action: '../components/insert.php',
            fields: [
                ['name' => 'kode', 'type' => 'text', 'label' => 'Kode Jurusan'],
                ['name' => 'nama_jurusan', 'type' => 'text', 'label' => 'Nama Jurusan']
            ]
        );
        renderTable('jurusan', ['id', 'kode', 'nama_jurusan'], 'Jurusan');
    ?>
    <script src="../public/modal.js"></script>
</body>
</html>