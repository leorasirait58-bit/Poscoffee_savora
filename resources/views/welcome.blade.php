<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Savora Premium</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
body { font-family: 'Poppins', sans-serif; }

.bg-glow {
    background: 
        linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.85)),
        url('https://images.unsplash.com/photo-1509042239860-f550ce710b93');
    background-size: cover;
    background-position: center;
}

.glass {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,0.1);
}

.card-hover:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 20px 40px rgba(0,0,0,0.5),
                0 0 20px rgba(210,180,140,0.3);
}

.btn-glow:hover {
    box-shadow: 0 0 15px #d2b48c;
    transform: scale(1.1);
}

.filter-btn.active {
    background: #d2b48c;
    color: black;
}

* { transition: all 0.3s ease; }
</style>
</head>

<body class="bg-glow text-white">

<!-- HERO -->
<section id="home" class="h-screen flex flex-col justify-center items-center text-center relative overflow-hidden">

    <!-- NAVBAR -->
    <div class="absolute top-0 w-full flex justify-between items-center p-6 z-10 glass">
        <h1 class="text-2xl font-bold">☕ Savora</h1>

        <div class="space-x-6 text-sm">
            <a href="#home">Home</a>
            <a href="#menu">Menu</a>

            <button onclick="openCart()" 
                class="bg-[#d2b48c] text-black px-4 py-1 rounded-full btn-glow">
                🛒
            </button>
        </div>
    </div>

    <div class="glass p-10 rounded-3xl z-10 shadow-2xl">
        <h1 class="text-5xl font-bold mb-4">
            Taste The <span class="text-[#d2b48c]">Luxury</span>
        </h1>
        <p class="text-gray-300 mb-6">Not just food, it's an experience ☕</p>

        <button onclick="document.getElementById('menu').scrollIntoView()"
            class="bg-[#d2b48c] text-black px-6 py-2 rounded-full btn-glow">
            Explore Menu
        </button>
    </div>
</section>

<!-- PILIH MEJA -->
<section class="p-10">
<div class="max-w-6xl mx-auto">

    <h2 class="text-2xl font-bold mb-4">Pilih Meja</h2>

    <div id="mejaContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4">

        @foreach($mejas as $meja)
        <div 
            onclick="pilihMeja({{ $meja->id }}, this)"
            class="meja-item p-4 rounded-xl text-center font-bold
            {{ strtolower(trim($meja->status ?? 'kosong')) == 'kosong'
                ? 'bg-green-500/70 cursor-pointer'
                : 'bg-red-500/70 pointer-events-none opacity-60' }}">

            <div class="text-lg">Meja {{ $meja->nomor }}</div>

            <small>
                {{ strtolower(trim($meja->status ?? 'kosong')) == 'kosong' 
                    ? '🟢 Kosong' 
                    : '🔴 Penuh' }}
            </small>
        </div>
        @endforeach

    </div>

</div>
</section>

<!-- MENU -->
<section id="menu" class="p-10">
<div class="max-w-6xl mx-auto">

    <h2 class="text-3xl font-bold mb-6">Featured Menu</h2>
        

    </div>

    <!-- FILTER -->
    <div class="flex gap-3 mb-8">
        <button onclick="filterMenu('all', this)" class="filter-btn active px-4 py-2 glass rounded-full">All</button>
        <button onclick="filterMenu('1', this)" class="filter-btn px-4 py-2 glass rounded-full">Makanan</button>
        <button onclick="filterMenu('2', this)" class="filter-btn px-4 py-2 glass rounded-full">Minuman</button>
        <button onclick="filterMenu('3', this)" class="filter-btn px-4 py-2 glass rounded-full">Dessert</button>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($menus as $menu)
        <div class="menu-item glass p-4 rounded-3xl shadow-xl card-hover"
            data-kategori="{{ $menu->jenis_id }}">

            <div class="overflow-hidden rounded-2xl">
                <img src="{{ $menu->foto ? Storage::url($menu->foto) : 'https://via.placeholder.com/300' }}"
                    class="h-48 w-full object-cover hover:scale-110">
            </div>

            <h3 class="mt-3 font-semibold text-lg">{{$menu->nmmenu}}</h3>

            <p class="text-sm text-gray-300">
                {{$menu->deskripsi ?? 'Tidak ada deskripsi'}}
            </p>

            <div class="flex justify-between items-center mt-4">
                <span class="text-[#d2b48c] font-bold text-lg">
                    Rp {{$menu->harga}}
                </span>

                <button onclick="addToCart('{{ $menu->nmmenu }}', {{$menu->harga}})"
                    class="bg-[#d2b48c] text-black px-3 py-1 rounded-full btn-glow">
                    + Add
                </button>
            </div>
        </div>
        @endforeach

    </div>
</div>
</section>

<!-- TESTIMONI -->
<section class="p-10">
<div class="max-w-6xl mx-auto text-center">

    <h2 class="text-3xl font-bold mb-10">💬 What Our Customers Say</h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- TESTI 1 -->
        <div class="glass p-6 rounded-3xl shadow-xl card-hover">
            <p class="text-gray-300 italic">
                "Makanannya enak banget, tempatnya juga cozy. Pelayanan cepat!"
            </p>
            <div class="mt-4 font-bold text-[#d2b48c]">⭐️⭐️⭐️⭐️⭐️</div>
            <h4 class="mt-2 font-semibold">Ayu sari</h4>
        </div>

        <!-- TESTI 2 -->
        <div class="glass p-6 rounded-3xl shadow-xl card-hover">
            <p class="text-gray-300 italic">
                "Suka banget sama konsepnya, berasa makan di cafe mahal 😍"
            </p>
            <div class="mt-4 font-bold text-[#d2b48c]">⭐️⭐️⭐️⭐️⭐️</div>
            <h4 class="mt-2 font-semibold">Mahendra</h4>
        </div>

        <!-- TESTI 3 -->
        <div class="glass p-6 rounded-3xl shadow-xl card-hover">
            <p class="text-gray-300 italic">
                "Menu banyak pilihan, harga masih masuk akal. Recommended!"
            </p>
            <div class="mt-4 font-bold text-[#d2b48c]">⭐️⭐️⭐️⭐️⭐️</div>
            <h4 class="mt-2 font-semibold">Bayu</h4>
        </div>

    </div>
</div>
</section>

<!-- CART -->
<div id="cartModal" class="fixed inset-0 bg-black/70 hidden justify-center items-center backdrop-blur-sm">

    <div class="glass w-[400px] p-6 rounded-3xl shadow-2xl">
        
        <h2 class="text-xl font-bold mb-4">🛒 Your Order</h2>

        <ul id="cartList" class="space-y-2 max-h-40 overflow-y-auto"></ul>

        <h3 class="mt-4 font-bold text-[#d2b48c]">
            Total: Rp <span id="total">0</span>
        </h3>

        <div class="flex justify-between mt-4">
            <button onclick="closeCart()" 
                class="bg-gray-500 px-4 py-2 rounded">
                Close
            </button>

            <button onclick="checkout()" 
                class="bg-[#d2b48c] text-black px-4 py-2 rounded btn-glow">
                Checkout
            </button>
        </div>

    </div>
</div>

<script>
let cart = {};

// FILTER
function filterMenu(kategori, btn) {
    let items = document.querySelectorAll('.menu-item');
    let buttons = document.querySelectorAll('.filter-btn');

    buttons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    items.forEach(item => {
        if (kategori === 'all') {
            item.style.display = 'block';
        } else {
            item.style.display =
                item.getAttribute('data-kategori') === kategori
                ? 'block'
                : 'none';
        }
    });
}

// CART + VALIDASI MEJA
function addToCart(nama, harga) {

    let meja = document.getElementById('mejaSelect').value;

    if (!meja) {
        alert("Pilih meja dulu ya!");
        return;
    }

    if (!cart[nama]) {
        cart[nama] = { harga: harga, qty: 1 };
    } else {
        cart[nama].qty += 1;
    }

    renderCart();
    openCart();
}

function tambahItem(nama) {
    cart[nama].qty += 1;
    renderCart();
}

function kurangItem(nama) {
    cart[nama].qty -= 1;
    if (cart[nama].qty <= 0) delete cart[nama];
    renderCart();
}

function renderCart() {
    const list = document.getElementById('cartList');
    list.innerHTML = '';
    let total = 0;

    for (let nama in cart) {
        let item = cart[nama];

        let li = document.createElement('li');
        li.className = "flex justify-between items-center";

        li.innerHTML = `
            <div>
                ${nama} <br>
                <small>Rp ${item.harga} x ${item.qty}</small>
            </div>

            <div class="flex gap-2 items-center">
                <button onclick="kurangItem('${nama}')" class="bg-gray-300 px-2 rounded text-black">-</button>
                <span>${item.qty}</span>
                <button onclick="tambahItem('${nama}')" class="bg-[#d2b48c] px-2 rounded text-black">+</button>
            </div>
        `;

        list.appendChild(li);
        total += item.harga * item.qty;
    }

    document.getElementById('total').textContent = total;
}

function openCart() {
    document.getElementById('cartModal').classList.remove('hidden');
    document.getElementById('cartModal').classList.add('flex');
}

function closeCart() {
    document.getElementById('cartModal').classList.add('hidden');
}

function checkout() {

    let meja = document.getElementById('mejaSelect').value;

    if (!meja) {
        alert("Pilih meja dulu!");
        return;
    }

    if (Object.keys(cart).length === 0) {
        alert("Keranjang kosong!");
        return;
    }

    alert("Pesanan berhasil untuk Meja " + meja);

    cart = {};
    renderCart();
    closeCart();
}

let selectedMeja = null;

// pilih meja
function pilihMeja(id, el) {
    let semua = document.querySelectorAll('.meja-item');

    semua.forEach(m => m.classList.remove('ring', 'ring-yellow-400'));

    el.classList.add('ring', 'ring-yellow-400');

    selectedMeja = id;
}

// update addToCart
function addToCart(nama, harga) {

    if (!selectedMeja) {
        alert("Pilih meja dulu!");
        return;
    }

    if (!cart[nama]) {
        cart[nama] = { harga: harga, qty: 1 };
    } else {
        cart[nama].qty += 1;
    }

    renderCart();
    openCart();
}

// update checkout
function checkout() {

    if (!selectedMeja) {
        alert("Pilih meja dulu!");
        return;
    }

    if (Object.keys(cart).length === 0) {
        alert("Keranjang kosong!");
        return;
    }

    alert("Pesanan berhasil untuk Meja " + selectedMeja);

    cart = {};
    renderCart();
    closeCart();
}
</script>

<!-- FOOTER -->
<footer class="mt-10 p-10 glass text-gray-300">

    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">

        <!-- BRAND -->
        <div>
            <h2 class="text-2xl font-bold text-white mb-3">☕ Savora</h2>
            <p class="text-sm">
                Experience the taste of luxury with our premium menu and cozy atmosphere.
            </p>
        </div>

        <!-- CONTACT -->
        <div>
            <h3 class="font-semibold text-white mb-3">Contact</h3>
            <p class="text-sm">📍 Pematangsiantar</p>
            <p class="text-sm">📞 0812-3456-7890</p>
            <p class="text-sm">✉️ savora@email.com</p>
        </div>

    </div>

    <!-- GARIS -->
    <div class="border-t border-white/10 mt-8 pt-4 text-center text-sm text-gray-400">
        © 2026 Savora. All rights reserved.
    </div>

</footer>

</body>
</html>