<?php
include 'admin/db.php';
session_start();

if (isset($_POST['login'])) {
    $role = $_POST['role'];

    if ($role === 'user') {
        header("Location: index.php"); // Pengguna biasa balik ke depan
        exit();
    } else {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password']; // Sebaiknya gunakan password_verify jika di-hash

        // Cek ke tabel users
        $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

        if (mysqli_num_rows($query) > 0) {
            $_SESSION['admin_shabah'] = $username; // Buat tanda pengenal (session)
            header("Location: admin/index.php"); // Masuk ke dashboard admin
        } else {
            $error = "Username atau Password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Apotek Shabah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-emerald-900 h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-emerald-800 mb-6 italic">Apotek Shabah</h1>

        <?php if (isset($error)) echo "<p class='text-red-500 mb-4 text-sm'>$error</p>"; ?>

        <form method="POST" class="space-y-4 text-left">
            <div>
                <label class="block text-sm font-bold mb-1">Masuk Sebagai</label>
                <select name="role" id="roleSelect" onchange="toggleAdmin()" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="user">Pengguna (Tamu)</option>
                    <option value="admin">Administrator (Admin)</option>
                </select>
            </div>

            <div id="adminForm" class="hidden space-y-4">
                <input type="text" name="username" placeholder="Username" class="w-full border p-3 rounded-xl">
                <input type="password" name="password" placeholder="Password" class="w-full border p-3 rounded-xl">
            </div>

            <button type="submit" name="login" class="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl hover:bg-emerald-700 transition">
                Masuk
            </button>
        </form>
    </div>

    <script>
        function toggleAdmin() {
            const role = document.getElementById('roleSelect').value;
            const form = document.getElementById('adminForm');
            form.classList.toggle('hidden', role !== 'admin');
        }
    </script>
</body>

</html>