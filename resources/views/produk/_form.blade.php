{{-- Catatan: @csrf TIDAK diletakkan di sini karena halaman yang meng-include
     partial ini (create.blade.php / edit.blade.php) sudah menaruh @csrf
     sendiri tepat di dalam tag <form>. --}}

<!-- Tampilkan Foto Saat Ini (Jika Mode Edit & Ada Foto) -->
@if (!empty($produk->foto))
    <div class="mb-3">
        <label class="form-label text-secondary small">Foto Saat Ini</label><br>
        <img src="{{ asset('storage/' . $produk->foto) }}"
             width="150"
             alt="{{ $produk->nama ?? 'Foto Produk' }}"
             class="img-thumbnail rounded-3 zoomable-img"
             style="background: #0f172a; border-color: rgba(255, 255, 255, 0.15);">
    </div>
@endif

<!-- Upload Foto Baru & Real-time Preview -->
<div class="row mb-3">
    <div class="col-md-6 mb-2 mb-md-0">
        <label class="form-label">Upload Gambar Produk</label>
        <input type="file"
               name="foto"
               onchange="previewImage(this)"
               accept="image/*"
               class="form-control @error('foto') is-invalid @enderror">
        <small class="text-secondary d-block mt-1">Format: JPG, JPEG, PNG (Maks 2MB)</small>
        @error('foto')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Preview Foto Baru</label><br>
        <img id="preview" class="img-thumbnail rounded-3 zoomable-img" style="display:none; max-height: 120px; background: #0f172a; border-color: rgba(255, 255, 255, 0.15);" width="150">
    </div>
</div>

<!-- Nama Produk -->
<div class="mb-3">
    <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
    <input type="text" 
           id="name"
           name="name"
           placeholder="Contoh: Kopi Susu Gula Aren, Laptop Asus, dll."
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $produk->nama ?? '') }}"
           required>
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="row">
    <!-- Harga Beli -->
    <div class="col-md-6 mb-3">
        <label for="purchase_price" class="form-label">Harga Beli (Rp) <span class="text-danger">*</span></label>
        <input type="number" 
               id="purchase_price"
               name="purchase_price"
               placeholder="Contoh: 15000"
               min="0"
               class="form-control @error('purchase_price') is-invalid @enderror"
               value="{{ old('purchase_price', $produk->harga_beli ?? '') }}"
               required>
        @error('purchase_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Harga Jual -->
    <div class="col-md-6 mb-3">
        <label for="selling_price" class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
        <input type="number" 
               id="selling_price"
               name="selling_price"
               placeholder="Contoh: 20000"
               min="0"
               class="form-control @error('selling_price') is-invalid @enderror"
               value="{{ old('selling_price', $produk->harga_jual ?? '') }}"
               required>
        @error('selling_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<!-- Stok -->
<div class="mb-3">
    <label for="stock" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
    <input type="number" 
           id="stock"
           name="stock"
           placeholder="Masukkan jumlah stok (misal: 50)"
           min="0"
           class="form-control @error('stock') is-invalid @enderror"
           value="{{ old('stock', $produk->stok ?? '') }}"
           required>
    @error('stock')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- Diskon -->
<div class="mb-3">
    <label for="diskon_persen" class="form-label">
        Diskon (%) <span class="text-secondary fw-normal">(opsional)</span>
    </label>
    <div class="input-group">
        <input type="number"
               id="diskon_persen"
               name="diskon_persen"
               placeholder="0"
               min="0"
               max="100"
               step="0.1"
               class="form-control @error('diskon_persen') is-invalid @enderror"
               value="{{ old('diskon_persen', $produk->diskon_persen ?? 0) }}">
        <span class="input-group-text bg-dark border-secondary text-secondary">%</span>
        @error('diskon_persen')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div id="diskon-hint" class="form-text small mt-2 p-2 rounded-3" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.08);">
        Isi Harga Beli &amp; Harga Jual terlebih dahulu untuk melihat rentang diskon yang diperbolehkan.
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    // ------------------------------------------------------------------
    // Kalkulasi live rentang diskon (%) yang diperbolehkan.
    // Aturan: diskon = 0% selalu boleh (tidak ada diskon). Jika diisi
    // lebih dari 0%, harus berada di antara 1/3 dan 2/3 dari persentase
    // laba produk (contoh: laba 30% -> rentang diskon 10% - 20%).
    // Nilai ini HANYA bantuan visual di sisi klien; validasi sesungguhnya
    // tetap dilakukan di server (App\Models\Produk::diskonValid()).
    // ------------------------------------------------------------------
    (function () {
        const purchaseInput = document.getElementById('purchase_price');
        const sellingInput  = document.getElementById('selling_price');
        const diskonInput   = document.getElementById('diskon_persen');
        const hintBox       = document.getElementById('diskon-hint');

        if (!purchaseInput || !sellingInput || !diskonInput || !hintBox) {
            return;
        }

        function formatPersen(n) {
            return (Math.round(n * 10) / 10).toString().replace('.', ',');
        }

        function formatRupiah(n) {
            return 'Rp ' + Math.round(n).toLocaleString('id-ID');
        }

        function updateDiskonHint() {
            const hargaBeli = parseFloat(purchaseInput.value) || 0;
            const hargaJual = parseFloat(sellingInput.value) || 0;

            if (hargaJual <= 0) {
                hintBox.className = 'form-text small mt-2 p-2 rounded-3 text-secondary';
                hintBox.textContent = 'Isi Harga Beli & Harga Jual terlebih dahulu untuk melihat rentang diskon yang diperbolehkan.';
                diskonInput.removeAttribute('min');
                diskonInput.removeAttribute('max');
                return;
            }

            const labaPersen = ((hargaJual - hargaBeli) / hargaJual) * 100;

            if (labaPersen <= 0) {
                hintBox.className = 'form-text small mt-2 p-2 rounded-3 text-danger';
                hintBox.textContent = 'Harga jual harus lebih besar dari harga beli agar produk memiliki laba dan bisa diberi diskon.';
                diskonInput.setAttribute('min', 0);
                diskonInput.setAttribute('max', 0);
                return;
            }

            const minDiskon = Math.round((labaPersen / 3) * 10) / 10;
            const maxDiskon = Math.round(((labaPersen * 2) / 3) * 10) / 10;
            const diskonNow = parseFloat(diskonInput.value) || 0;
            const hargaSetelahDiskon = hargaJual - (hargaJual * diskonNow / 100);

            diskonInput.setAttribute('min', 0);
            diskonInput.setAttribute('max', maxDiskon);

            hintBox.className = 'form-text small mt-2 p-2 rounded-3 text-info';
            hintBox.innerHTML =
                'Estimasi laba: <strong>' + formatPersen(labaPersen) + '%</strong>. ' +
                'Diskon yang diperbolehkan: <strong>' + formatPersen(minDiskon) + '% - ' + formatPersen(maxDiskon) + '%</strong> ' +
                '(atau kosongkan / isi 0 jika tidak ingin memberi diskon).' +
                (diskonNow > 0
                    ? '<br>Harga setelah diskon saat ini: <strong>' + formatRupiah(hargaSetelahDiskon) + '</strong>'
                    : '');
        }

        [purchaseInput, sellingInput, diskonInput].forEach(function (el) {
            el.addEventListener('input', updateDiskonHint);
        });

        updateDiskonHint();
    })();
</script>