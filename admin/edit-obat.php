<?php
include 'koneksi.php';
include 'auth.php';

// Ambil ID dari URL, misalnya: edit-obat.php?id=1
$id_obat = $_GET['id'];

// Query untuk mengambil data obat berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM obat WHERE id = '$id_obat'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    die("Data obat tidak ditemukan!");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Obat - Panel Apoteker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 p-6">

    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-green-600 p-6 text-white flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">Edit Informasi Obat</h2>
                <p class="text-green-100 text-sm">Pastikan data dosis dan stok akurat</p>
            </div>
            <i data-lucide="pill" class="w-8 h-8 opacity-50"></i>
        </div>

        <form action="proses-edit-obat.php" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="id_obat" value="<?php echo $data['id']; ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Obat</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i data-lucide="package" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="nama_obat" value="<?php echo $data['nama']; ?>"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="Antibiotik" <?php echo $data['kategori'] == 'Antibiotik' ? 'selected' : ''; ?>>Antibiotik</option>
                        <option value="Vitamin" <?php echo $data['kategori'] == 'Vitamin' ? 'selected' : ''; ?>>Vitamin</option>
                        <option value="Obat Bebas" <?php echo $data['kategori'] == 'Obat Bebas' ? 'selected' : ''; ?>>Obat Bebas</option>
                        <option value="Obat Keras" <?php echo $data['kategori'] == 'Obat Keras' ? 'selected' : ''; ?>>Obat Keras</option>
                        <option value="Obat Herbal" <?php echo $data['kategori'] == 'Obat Herbal' ? 'selected' : ''; ?>>Obat Herbal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" value="<?php echo $data['harga']; ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Tersisa</label>
                    <input type="number" name="stok" value="<?php echo $data['stok']; ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan</label>
                    <input type="text" name="satuan" value="<?php echo $data['satuan']; ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                <a href="manage-obat.php" class="text-gray-500 hover:text-gray-700 font-medium">Batal</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-bold flex items-center gap-2 transition shadow-lg shadow-green-100">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>