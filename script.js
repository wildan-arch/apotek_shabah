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
function renderHasil(hasil) {
  if (hasil.length === 0) {
    hasilContainer.innerHTML = '<p class="text-center text-red-500 py-10 col-span-full">Obat tidak ditemukan.</p>';
    return;
  }

  hasilContainer.innerHTML = hasil
    .map(
      (obat, index) => `
        <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm hover:shadow-md transition text-left">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-bold text-emerald-900 text-lg">${obat.nama}</h4>
                    <p class="text-[10px] text-slate-400 font-bold uppercase italic">${obat.kategori}</p>
                    <p class="text-[11px] ${parseInt(obat.stok) < 10 ? "text-red-500" : "text-emerald-500"} font-semibold">Stok: ${obat.stok} ${obat.satuan}</p>
                </div>
                <p class="text-emerald-700 font-bold text-sm">Rp ${parseInt(obat.harga).toLocaleString("id-ID")}</p>
            </div>
            <div class="flex items-center gap-2 pt-4 border-t border-slate-50">
                <input type="number" id="qty-${index}" min="1" value="1" class="w-full bg-slate-50 border-none rounded-xl px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-emerald-500">
                <button onclick="tambahKeKeranjang('${obat.nama}', ${obat.harga}, 'qty-${index}', '${obat.satuan}')" class="bg-emerald-600 text-white p-2 rounded-xl hover:bg-emerald-700 transition">
                    <i data-lucide="plus" class="w-5 h-5"></i>
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
