<?php
session_start();
include '../connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm'] ?? '');

    if ($username === '' || $password === '' || $confirm === '') {
        $error = 'Semua field harus diisi.';
    } elseif ($password !== $confirm) {
        $error = 'Password dan konfirmasi tidak cocok.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } else {
        // cek username sudah ada
        $chk = $conn->prepare('SELECT id FROM admin WHERE username = ? AND deleted_at IS NULL');
        if ($chk) {
            $chk->bind_param('s', $username);
            $chk->execute();
            $chk->store_result();
            if ($chk->num_rows > 0) {
                $error = 'Username sudah digunakan.';
                $chk->close();
            } else {
                $chk->close();
                // insert admin baru
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $ins = $conn->prepare('INSERT INTO admin (username, password) VALUES (?, ?)');
                if ($ins) {
                    $ins->bind_param('ss', $username, $hashed);
                    if ($ins->execute()) {
                        $ins->close();
                        $conn->close();
                        // redirect ke login
                        header('Location: index.php?registered=1');
                        exit();
                    } else {
                        $error = 'Gagal menyimpan data.';
                        $ins->close();
                    }
                } else {
                    $error = 'Kesalahan server (prepare gagal).';
                }
            }
        } else {
            $error = 'Kesalahan server (prepare gagal).';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Register - SMK TI Bali Global Denpasar</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-center">Register Admin</h2>

        <?php if ($error): ?>
            <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-200 p-3 rounded">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" class="space-y-4" autocomplete="off">
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input name="username" type="text" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#0b63d6] focus:border-[#0b63d6] px-3 py-2"
                       value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input name="password" type="password" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#0b63d6] focus:border-[#0b63d6] px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input name="confirm" type="password" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#0b63d6] focus:border-[#0b63d6] px-3 py-2">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="w-full bg-[#0b63d6] hover:bg-[#094fb3] text-white font-semibold py-2 px-4 rounded">
                    Register
                </button>
            </div>

            <p class="text-center text-sm text-gray-600 mt-3">
                Sudah punya akun? <a href="index.php" class="text-[#0b63d6] font-semibold">Login</a>
            </p>
        </form>
    </div>
</body>
</html>