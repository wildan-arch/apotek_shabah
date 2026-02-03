<?php
include 'admin/koneksi.php';
// Ambil semua data obat untuk pencarian JavaScript nanti
$query = mysqli_query($conn, "SELECT * FROM obat WHERE stok > 0 ORDER BY nama ASC");
$semua_obat = [];
while ($row = mysqli_fetch_assoc($query)) {
  $semua_obat[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Apotek Shabah - Solusi Kesehatan Terpercaya</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      font-family: "Poppins", sans-serif;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in-up {
      animation: fadeInUp 0.3s ease-out;
    }
  </style>
</head>

<body class="bg-slate-50 text-slate-800" id="beranda">
  <header class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm">
    <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center relative">
      <div class="flex items-center gap-2 text-2xl font-bold text-emerald-600">
        <i data-lucide="pill" class="w-8 h-8"></i>
        <span>Apotek <span class="text-emerald-800">Shabah</span></span>
      </div>

      <button title="menu-btn" class="md:hidden p-2 text-slate-600 hover:text-emerald-600 focus:outline-none" id="menu-btn">
        <i data-lucide="menu" id="menu-icon"></i>
      </button>

      <ul
        class="absolute md:static top-full left-0 w-full md:w-auto bg-white md:bg-transparent shadow-lg md:shadow-none flex-col md:flex-row flex items-center gap-6 md:gap-8 font-medium text-slate-600 p-8 md:p-0 transition-all duration-300 ease-in-out opacity-0 -translate-y-5 pointer-events-none md:opacity-100 md:translate-y-0 md:pointer-events-auto"
        id="nav-list">
        <li><a href="#beranda" class="hover:text-emerald-600 transition nav-link">Beranda</a></li>
        <li><a href="#tentang-kami" class="hover:text-emerald-600 transition nav-link">Tentang Kami</a></li>
        <li><a href="#layanan" class="hover:text-emerald-600 transition nav-link">Layanan</a></li>
        <li><a href="#produk" class="hover:text-emerald-600 transition nav-link">Produk</a></li>
        <li><a href="login.php" class="text-xs text-slate-400 hover:text-emerald-600 transition">Admin Login</a></li>
        <li class="w-full md:w-auto text-center">
          <a href="https://wa.me/6285745320912" class="bg-emerald-600 text-white px-6 py-3 rounded-xl hover:bg-emerald-700 transition flex items-center justify-center gap-2"> <i data-lucide="phone" class="w-4 h-4"></i> Hubungi Kami </a>
        </li>
      </ul>
    </nav>
  </header>

  <section class="pt-32 pb-20 px-6 max-w-7xl mx-auto">
    <div class="grid md:grid-cols-2 gap-12 items-center">
      <div class="space-y-6">
        <span class="bg-emerald-100 text-emerald-700 px-4 py-1 rounded-full text-sm font-semibold uppercase tracking-wider">Apotek Terpercaya</span>
        <h1 class="text-4xl md:text-6xl font-bold leading-tight">Kesehatan Anda, <br /><span class="text-emerald-600">Prioritas Utama Kami</span></h1>
        <p class="text-lg text-slate-600 leading-relaxed">Dapatkan obat asli, konsultasi gratis dengan apoteker profesional, dan layanan antar cepat langsung ke depan pintu rumah Anda.</p>
        <div class="flex flex-wrap gap-4">
          <a href="#produk" class="bg-emerald-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">Cari Obat</a>
          <a href="https://wa.me/6285745320912" class="bg-white border-2 border-emerald-600 text-emerald-600 px-8 py-4 rounded-xl font-bold hover:bg-emerald-50 transition">Konsultasi Apoteker Ahli</a>
          >
        </div>
      </div>
      <div class="relative group">
        <div class="absolute -inset-4 bg-emerald-200/50 rounded-full blur-3xl group-hover:bg-emerald-300/50 transition"></div>
        <div class="relative bg-white p-4 rounded-3xl shadow-2xl rotate-3 group-hover:rotate-0 transition duration-500">
          <img src="https://images.unsplash.com/photo-1586015555751-63bb77f4322a?auto=format&fit=crop&q=80&w=800" alt="Pharmacy" class="rounded-2xl w-full h-[400px] object-cover" />
          <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-3">
            <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
              <i data-lucide="check-circle"></i>
            </div>
            <div>
              <p class="text-xs text-slate-500 uppercase font-bold tracking-tighter">Terverifikasi</p>
              <p class="font-bold text-slate-800 text-sm">100% Obat Asli</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="tentang-kami" class="py-24 bg-white scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
      <div class="relative">
        <div class="w-full h-[450px] bg-emerald-600 rounded-3xl overflow-hidden relative z-10">
          <div class="absolute inset-0 flex items-center justify-center text-white/20">
            <i data-lucide="hospital" class="w-64 h-64"></i>
          </div>
          <img src="https://images.unsplash.com/photo-1576602976047-174e57a47881?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover mix-blend-overlay" alt="gamabr_1" />
        </div>
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-100 rounded-full -z-0"></div>
      </div>
      <div class="space-y-6">
        <h3 class="text-emerald-600 font-bold uppercase tracking-widest text-sm">Tentang Kami</h3>
        <h2 class="text-4xl font-bold leading-snug">Hadir dengan Produk 100% Asli & Terpercaya</h2>
        <p class="text-slate-600"><strong>Apotek Shabah</strong> hadir sebagai mitra kesehatan baru yang berkomitmen menyediakan obat-obatan berkualitas tinggi dan layanan kefarmasian profesional bagi masyarakat.</p>
        <p class="text-slate-600">Kami menggabungkan teknologi pemesanan online dengan keramahan layanan apoteker konvensional untuk memastikan Anda mendapatkan perawatan terbaik.</p>
        <div class="grid grid-cols-2 gap-8 pt-4">
          <div class="border-l-4 border-emerald-600 pl-4">
            <h4 class="text-3xl font-bold">Fast Response</h4>
            <p class="text-sm text-slate-500">Layanan Apoteker</p>
          </div>
          <div class="border-l-4 border-emerald-600 pl-4">
            <h4 class="text-3xl font-bold">100%</h4>
            <p class="text-sm text-slate-500">Jaminan Keaslian</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="layanan" class="py-20 bg-emerald-900 text-white scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10 text-center">
      <div class="p-8 rounded-2xl bg-emerald-800/50 hover:bg-emerald-800 transition">
        <i data-lucide="shield-check" class="w-12 h-12 mx-auto mb-6 text-emerald-400"></i>
        <h3 class="text-xl font-bold mb-4">100% Obat Asli</h3>
        <p class="text-emerald-100/70">Seluruh produk resmi terdaftar di BPOM dan bersumber dari distributor resmi.</p>
      </div>
      <div class="p-8 rounded-2xl bg-emerald-800/50 hover:bg-emerald-800 transition border-2 border-emerald-500/30">
        <i data-lucide="user-cog" class="w-12 h-12 mx-auto mb-6 text-emerald-400"></i>
        <h3 class="text-xl font-bold mb-4">Apoteker Siaga</h3>
        <p class="text-emerald-100/70">Konsultasi gratis mengenai dosis dan aturan pakai langsung dengan ahlinya.</p>
      </div>
      <div class="p-8 rounded-2xl bg-emerald-800/50 transition ">
        <i data-lucide="truck" class="w-12 h-12 mx-auto mb-6 text-emerald-400 opacity-50"></i>
        <h3 class="text-xl font-bold mb-4 opacity-50">Antar Cepat</h3>
        <p class="text-emerald-100/70 opacity-50">Segera Hadir</p>
      </div>
    </div>
  </section>
  <!-- produk -->
  <section id="produk" class="py-24 max-w-7xl mx-auto px-6 scroll-mt-20 text-center">
    <h3 class="text-emerald-600 font-bold uppercase tracking-widest text-sm mb-4">Katalog Kesehatan</h3>
    <h2 class="text-4xl font-bold mb-16">Kategori Terpopuler</h2>

    <!-- fitur pencarian -->
    <section class="py-16 bg-white shadow-inner">
      <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-10">
          <h2 class="text-3xl font-bold mb-4 text-emerald-800">Cek Ketersediaan Obat</h2>
          <p class="text-slate-500">Ketik nama obat untuk melihat stok dan estimasi harga secara real-time.</p>
        </div>

        <div class="relative max-w-lg mx-auto mb-10">
          <input type="text" id="inputCari" placeholder="Cari obat (contoh: Paracetamol)..." autocomplete="off" class="w-full px-6 py-4 rounded-full border-2 border-emerald-100 focus:border-emerald-500 outline-none transition shadow-sm pl-14" />
          <i data-lucide="search" class="absolute left-5 top-4 text-emerald-500"></i>
        </div>

        <div id="hasilPencarian" class="grid gap-4">
          <p class="text-center text-slate-400 italic">Silakan ketik nama obat...</p>
        </div>
      </div>
      <!-- fitur keranjang belanja -->
      <div class="md:col-span-2 grid gap-4">
        <p class="text-center text-slate-400 italic py-10">Cari obat di atas untuk memulai...</p>
      </div>

      <div class="bg-slate-50 p-6 rounded-3xl border border-emerald-100 h-fit sticky top-24">
        <div class="flex items-center gap-2 mb-6 text-emerald-800">
          <i data-lucide="shopping-bag" class="w-6 h-6"></i>
          <h3 class="font-bold text-xl">Keranjang Anda</h3>
        </div>

        <div id="isi-keranjang" class="space-y-3 mb-6 max-h-60 overflow-y-auto pr-2"></div>

        <div class="border-t border-emerald-200 pt-4 mb-6">
          <div class="flex justify-between items-center font-bold">
            <span class="text-slate-500">Total:</span>
            <span id="grand-total" class="text-2xl text-emerald-700 font-mono">Rp 0</span>
          </div>
        </div>

        <button onclick="checkoutWA()" class="w-full bg-emerald-800 text-white py-4 rounded-2xl font-bold hover:shadow-xl hover:bg-emerald-900 transition flex items-center justify-center gap-3">
          Pesan via WhatsApp <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </button>
      </div>
      </div>
    </section>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-left">
      <div class="bg-white p-8 rounded-3xl shadow-lg border border-slate-100 hover:border-emerald-500 transition-all group">
        <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition">
          <i data-lucide="package"></i>
        </div>
        <h4 class="text-xl font-bold mb-2">Vitamin</h4>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">Multivitamin harian untuk menjaga daya tahan tubuh Anda.</p>
        <a href="https://wa.me/6285745320912" class="text-emerald-600 font-bold flex items-center gap-2 hover:gap-4 transition-all">Pesan <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </div>
      <div class="bg-white p-8 rounded-3xl shadow-lg border border-slate-100 hover:border-emerald-500 transition-all group">
        <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition">
          <i data-lucide="thermometer"></i>
        </div>
        <h4 class="text-xl font-bold mb-2">Alat Medis</h4>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">Termometer digital, tensimeter, dan alat kesehatan lainnya.</p>
        <a href="https://wa.me/6285745320912" class="text-emerald-600 font-bold flex items-center gap-2 hover:gap-4 transition-all">Cek Stok <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </div>
      <div class="bg-white p-8 rounded-3xl shadow-lg border border-slate-100 hover:border-emerald-500 transition-all group">
        <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition">
          <i data-lucide="bandage"></i>
        </div>
        <h4 class="text-xl font-bold mb-2">P3K</h4>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">Plester, antiseptik, dan perlengkapan pertolongan pertama.</p>
        <a href="https://wa.me/6285745320912" class="text-emerald-600 font-bold flex items-center gap-2 hover:gap-4 transition-all">Beli <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </div>
      <div class="bg-white p-8 rounded-3xl shadow-lg border border-slate-100 hover:border-emerald-500 transition-all group">
        <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition">
          <i data-lucide="baby"></i>
        </div>
        <h4 class="text-xl font-bold mb-2">Ibu & Anak</h4>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">Susu bayi, popok, dan nutrisi khusus ibu hamil.</p>
        <a href="https://wa.me/6285745320912" class="text-emerald-600 font-bold flex items-center gap-2 hover:gap-4 transition-all">Cari <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </div>
    </div>
  </section>

  <section id="kontak" class="py-20 bg-slate-100">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10">
      <div class="bg-white p-10 rounded-3xl shadow-md space-y-6">
        <h2 class="text-3xl font-bold italic">Lokasi & Jam</h2>
        <div class="flex items-start gap-4 text-slate-600">
          <i data-lucide="map-pin" class="text-emerald-600 mt-1"></i>
          <p>Jl. Raya Argosuko Wangkal RT. 20 RW. 04 <br /><span class="text-sm font-medium">(Depan Lapangan Argosuko)</span></p>
        </div>
        <div class="flex items-start gap-4 text-slate-600">
          <i data-lucide="clock" class="text-emerald-600 mt-1"></i>
          <p>Senin - Minggu: 08:00 - 21:00 <br /><span class="text-sm font-medium text-emerald-600">Hari Libur Tetap Buka</span></p>
        </div>
        <a href="https://maps.app.goo.gl/pAaA76RhM1aGPqJg9" target="_blank" rel="noopener" class="inline-block bg-slate-800 text-white px-8 py-3 rounded-lg hover:bg-slate-900 transition">Lihat di Google Maps</a>
      </div>
      <div class="bg-emerald-600 p-10 rounded-3xl text-white shadow-xl shadow-emerald-200">
        <i data-lucide="file-text" class="w-12 h-12 mb-6"></i>
        <h2 class="text-3xl font-bold mb-4">Punya Resep Dokter?</h2>
        <p class="mb-8 text-emerald-50">Ambil foto resep Anda dan kirimkan kepada kami melalui WhatsApp. Kami akan segera menyiapkan obatnya.</p>
        <a href="https://wa.me/6285745320912" class="bg-white text-emerald-600 px-8 py-4 rounded-xl font-bold hover:bg-emerald-50 transition block text-center">Kirim Foto Resep</a>
      </div>
    </div>
  </section>

  <footer class="py-12 border-t text-center text-slate-400 text-sm">
    <p>© 2024 <span class="font-bold text-slate-600">Apotek Shabah</span>. Melayani dengan Sepenuh Hati.</p>
  </footer>

  <!-- fitur detail obat -->
  <div id="modalDetail" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-[60] hidden">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-200">
      <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-emerald-50">
        <h2 id="modalNamaObat" class="text-2xl font-bold text-emerald-800 italic">Nama Obat</h2>
        <button onclick="tutupModal()" class="p-2 hover:bg-emerald-100 rounded-full transition">
          <i data-lucide="x" class="text-emerald-800"></i>
        </button>
      </div>

      <div class="p-8 space-y-6 max-h-[70vh] overflow-y-auto">
        <div class="flex justify-between items-center">
          <span id="modalKategori" class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider italic">Kategori</span>
          <span id="modalHarga" class="text-2xl font-mono font-bold text-emerald-600">Rp 0</span>
        </div>

        <div class="space-y-4">
          <div>
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
              <i data-lucide="info" class="w-4 h-4 text-emerald-600"></i> Deskripsi
            </h3>
            <p id="modalDeskripsi" class="text-slate-600 text-sm leading-relaxed mt-1">-</p>
          </div>

          <div>
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
              <i data-lucide="stethoscope" class="w-4 h-4 text-emerald-600"></i> Dosis & Aturan Pakai
            </h3>
            <p id="modalDosis" class="text-slate-600 text-sm italic mt-1">-</p>
          </div>

          <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Stok Tersedia</p>
            <p id="modalStok" class="text-slate-700 font-bold italic">0 Unit</p>
          </div>
        </div>
      </div>

      <div class="p-6 bg-slate-50 border-t border-slate-100 flex gap-4">
        <button onclick="tutupModal()" class="flex-1 py-3 text-slate-500 font-bold hover:text-slate-700 transition">Tutup</button>
        <a id="btnBeliWA" href="#" class="flex-[2] bg-emerald-600 text-white py-3 rounded-xl font-bold text-center hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition">
          Pesan Sekarang
        </a>
      </div>
    </div>
  </div>

  <a href="#beranda" title="beranda" class="fixed bottom-8 right-8 bg-emerald-600 text-white p-3 rounded-full shadow-2xl hover:-translate-y-2 transition duration-300">
    <i data-lucide="arrow-up"></i>
  </a>
  <!-- icons -->
  <script>
    lucide.createIcons();
  </script>
  <!-- script -->
  <script src="script.js" defer></script>
  <script>
    // Mengubah data PHP menjadi array JavaScript
    const daftarObat = <?php echo json_encode($semua_obat); ?>;
  </script>
</body>

</html>