<?php
session_start();
include '../connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        $stmt = $conn->prepare(
            'SELECT id, password FROM users WHERE username=? AND deleted_at IS NULL',
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();
            // Jika password sudah di-hash, gunakan password_verify
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit();
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Username tidak ditemukan!';
        }
        $stmt->close();
    } else {
        $error = 'Username dan password harus diisi!';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        .form-container { max-width: 350px; margin: 60px auto; padding: 24px; background: #f9f9f9; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 6px; }
        .button { padding: 6px 14px; background: #007bff; color: #fff; border: none; border-radius: 3px; margin-top: 14px; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
        <form method="post" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit" class="button">Login</button>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>
