<?php
include 'admin/koneksi.php';
session_start();

if (isset($_POST['login'])) {
    $role = $_POST['role'];

    if ($role === 'user') {
        header("Location: index.php");
        exit();
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Menggunakan Prepared Statement untuk keamanan maksimal
        $stmt = mysqli_prepare($conn, "SELECT username, password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            // Verifikasi password yang di-hash
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_shabah'] = $user['username'];
                header("Location: admin/index.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Apotek Shabah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-emerald-900 h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-emerald-800 mb-6 italic">Apotek Shabah</h1>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-xl mb-4 text-sm">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4 text-left">
            <div>
                <label class="block text-sm font-bold mb-1 text-gray-700">Masuk Sebagai</label>
                <select name="role" id="roleSelect" onchange="toggleAdmin()" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    <option value="user">Pengguna (Tamu)</option>
                    <option value="admin">Administrator (Admin)</option>
                </select>
            </div>

            <div id="adminForm" class="hidden space-y-4">
                <div>
                    <input type="text" name="username" placeholder="Username" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <input type="password" name="password" placeholder="Password" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
            </div>

            <button type="submit" name="login" class="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl hover:bg-emerald-700 transition shadow-lg">
                Masuk
            </button>
        </form>
    </div>

    <script>
        function toggleAdmin() {
            const role = document.getElementById('roleSelect').value;
            const form = document.getElementById('adminForm');
            if (role === 'admin') {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }
    </script>
</body>

</html>