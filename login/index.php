<?php
session_start();
include '../connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username !== '' && $password !== '') {
        // use admin table (created in connect.php)
        $stmt = $conn->prepare('SELECT id, password FROM admin WHERE username = ? AND deleted_at IS NULL');
        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($user_id, $hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $stmt->close();
                    $conn->close();
                    header('Location: ../index.php');
                    exit();
                } else {
                    $error = 'Password salah!';
                }
            } else {
                $error = 'Username tidak ditemukan!';
            }
            $stmt->close();
        } else {
            $error = 'Kesalahan server (prepare gagal).';
        }
    } else {
        $error = 'Username dan password harus diisi!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login - SMK TI Bali Global Denpasar</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-center">Login</h2>

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

            <div class="flex items-center justify-between">
                <button type="submit" class="w-full bg-[#0b63d6] hover:bg-[#094fb3] text-white font-semibold py-2 px-4 rounded">
                    Login
                </button>
            </div>
        </form>
    </div>
</body>
</html>
