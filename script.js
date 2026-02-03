// Inisialisasi Variabel Global
// dataObat sekarang mengambil isi dari daftarObat yang dikirim oleh PHP
let dataObat = typeof daftarObat !== "undefined" ? daftarObat : [];
let keranjang = [];

const inputCari = document.getElementById("inputCari");
const hasilContainer = document.getElementById("hasilPencarian");
const keranjangElement = document.getElementById("isi-keranjang");
const totalElement = document.getElementById("grand-total");

// 1. Fungsi Inisialisasi (Tidak perlu fetch JSON lagi)
function inisialisasiDatabase() {
  if (dataObat.length === 0) {
    hasilContainer.innerHTML = '<p class="text-center text-red-500 py-10 col-span-full">Database kosong atau gagal dimuat.</p>';
  } else {
    hasilContainer.innerHTML = '<p class="text-center text-slate-400 italic py-10 col-span-full">Database MySQL Siap. Silakan cari obat...</p>';
  }
}

// 2. Tampilkan Hasil Pencarian (Tetap sama, hanya penyesuaian parsing harga)
// 2. Tampilkan Hasil Pencarian
function renderHasil(hasil) {
  if (hasil.length === 0) {
    hasilContainer.innerHTML = '<p class="text-center text-red-500 py-10 col-span-full">Obat tidak ditemukan.</p>';
    return;
  }

  hasilContainer.innerHTML = hasil
    .map(
      (obat, index) => `
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 text-left relative overflow-hidden group">
            <div class="flex justify-between items-start mb-2">
                <div class="pr-4">
                    <h4 class="font-bold text-emerald-900 text-xl leading-tight mb-1">${obat.nama}</h4>
                    <span class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-1 rounded-full font-bold uppercase tracking-wider">${obat.kategori}</span>
                </div>
                <p class="text-emerald-600 font-extrabold text-lg italic">Rp ${parseInt(obat.harga).toLocaleString("id-ID")}</p>
            </div>

            <div class="mb-6">
                <p class="text-xs ${parseInt(obat.stok) < 10 ? "text-red-500" : "text-slate-400"} font-medium">
                    Stok: <span class="font-bold">${obat.stok} ${obat.satuan}</span>
                </p>
            </div>
            
            <div class="flex items-center gap-3 mt-auto">
                <div class="relative flex-grow">
                    <input type="number" id="qty-${index}" min="1" value="1" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-3 text-sm font-bold outline-none focus:border-emerald-500 focus:bg-white transition-all">
                </div>
                
                <button onclick="tambahKeKeranjang('${obat.nama}', ${obat.harga}, 'qty-${index}', '${obat.satuan}')" 
                    class="bg-emerald-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:scale-110 active:scale-95 transition-all duration-200 shrink-0">
                    <i data-lucide="plus" class="w-7 h-7"></i>
                </button>
            </div>
        </div>
    `,
    )
    .join("");
  lucide.createIcons();
}

// 3. Logika Keranjang & Validasi (Tetap sama)
function tambahKeKeranjang(nama, harga, idQty, satuan) {
  const qtyDipesan = parseInt(document.getElementById(idQty).value);
  const dataAsli = dataObat.find((o) => o.nama === nama);
  const indexExist = keranjang.findIndex((item) => item.nama === nama);
  const qtyDiKeranjang = indexExist > -1 ? keranjang[indexExist].qty : 0;

  if (qtyDipesan + qtyDiKeranjang > parseInt(dataAsli.stok)) {
    alert(`Stok terbatas! Sisa di gudang: ${dataAsli.stok} ${satuan}`);
    return;
  }

  if (indexExist > -1) {
    keranjang[indexExist].qty += qtyDipesan;
  } else {
    keranjang.push({ nama, harga: parseInt(harga), qty: qtyDipesan, satuan });
  }
  renderKeranjang();
}

function hapusItem(index) {
  keranjang.splice(index, 1);
  renderKeranjang();
}

function renderKeranjang() {
  if (keranjang.length === 0) {
    keranjangElement.innerHTML = '<p class="text-slate-400 italic text-sm text-center">Keranjang kosong</p>';
    totalElement.innerText = "Rp 0";
    return;
  }

  let grandTotal = 0;
  keranjangElement.innerHTML = keranjang
    .map((item, index) => {
      grandTotal += item.harga * item.qty;
      return `
            <div class="flex justify-between items-center mb-3 bg-white p-3 rounded-xl border border-slate-100">
                <div class="text-left text-xs">
                    <p class="font-bold text-emerald-900">${item.nama}</p>
                    <p class="text-slate-500">${item.qty} ${item.satuan} x Rp ${item.harga.toLocaleString("id-ID")}</p>
                </div>
                <button onclick="hapusItem(${index})" class="text-red-400 hover:text-red-600">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                </button>
            </div>`;
    })
    .join("");
  totalElement.innerText = `Rp ${grandTotal.toLocaleString("id-ID")}`;
  lucide.createIcons();
}

// 4. Integrasi WhatsApp (Tetap sama)
function checkoutWA() {
  if (keranjang.length === 0) return alert("Keranjang masih kosong!");
  const phone = "6285745320912";
  let daftarPesanan = keranjang.map((item) => `- ${item.nama} (${item.qty} ${item.satuan})`).join("%0A");
  const pesan = `Halo Apotek Shabah, saya mau pesan:%0A%0A${daftarPesanan}%0A%0A*Total: ${totalElement.innerText}*`;
  window.open(`https://wa.me/${phone}?text=${pesan}`, "_blank");
}

// 5. Event Listeners
inputCari.addEventListener("input", (e) => {
  const keyword = e.target.value.toLowerCase();
  if (keyword === "") {
    inisialisasiDatabase();
    return;
  } // Filter berdasarkan nama atau kategori dari data MySQL
  const hasilFilter = dataObat.filter((o) => o.nama.toLowerCase().includes(keyword) || o.kategori.toLowerCase().includes(keyword));
  renderHasil(hasilFilter);
});

// Jalankan saat halaman siap
inisialisasiDatabase();

// fungsi popUp detailObat
// Fungsi untuk membuka modal dan mengisi data
function bukaDetail(id) {
  // Cari data obat dari array daftarObat (yang berasal dari PHP)
  const obat = daftarObat.find((item) => item.id == id);

  if (obat) {
    document.getElementById("modalNamaObat").innerText = obat.nama;
    document.getElementById("modalKategori").innerText = obat.kategori || "Obat Umum";
    document.getElementById("modalHarga").innerText = "Rp " + parseInt(obat.harga).toLocaleString("id-ID");
    document.getElementById("modalStok").innerText = obat.stok + " " + (obat.satuan || "Unit"); // Asumsi kolom di database: deskripsi, dosis (sesuaikan dengan nama kolom DB kamu)

    document.getElementById("modalDeskripsi").innerText = obat.deskripsi || "Tidak ada deskripsi tersedia.";
    document.getElementById("modalDosis").innerText = obat.dosis || "Gunakan sesuai petunjuk dokter atau aturan pakai."; // Link WA Otomatis

    const pesanWA = `Halo Apotek Shabah, saya ingin bertanya lebih lanjut tentang obat: ${obat.nama}`;
    document.getElementById("btnBeliWA").href = `https://wa.me/6285745320912?text=${encodeURIComponent(pesanWA)}`; // Tampilkan Modal

    const modal = document.getElementById("modalDetail");
    modal.classList.remove("hidden");
    lucide.createIcons(); // Re-render icons di dalam modal
  }
}

function tutupModal() {
  document.getElementById("modalDetail").classList.add("hidden");
}

// Menutup modal jika klik di luar area konten
window.onclick = function (event) {
  const modal = document.getElementById("modalDetail");
  if (event.target == modal) {
    tutupModal();
  }
};
