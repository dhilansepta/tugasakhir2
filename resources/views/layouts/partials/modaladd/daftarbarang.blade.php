<div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBarangModal">Tambah Data Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('manage.store-barang') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="satuan_id" class="form-label">Satuan</label>
                        <select class="form-select" id="satuan_id" name="satuan_id" required>
                            <option value="">Pilih Satuan</option>
                            @foreach ($satuan as $item)
                                <option value="{{ $item->id }}">{{ $item->satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli Persatuan</label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual Persatuan</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
                    </div>
                    <div class="mb-3">
                        <label for="keuntungan" class="form-label">Keuntungan Persatuan (Tidak Boleh 0 atau < 0)</label>
                        <input type="number" class="form-control" id="keuntungan" name="keuntungan" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Sisa Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const hargaBeliInput = document.getElementById('harga_beli');
    const hargaJualInput = document.getElementById('harga_jual');
    const keuntunganInput = document.getElementById('keuntungan');

    function hitungKeuntungan() {
        const hargaBeli = parseInt(hargaBeliInput.value) || 0;
        const hargaJual = parseInt(hargaJualInput.value) || 0;
        const keuntungan = hargaJual - hargaBeli;
        keuntunganInput.value = keuntungan;
    }

    hargaBeliInput.addEventListener('input', hitungKeuntungan);
    hargaJualInput.addEventListener('input', hitungKeuntungan);
</script>