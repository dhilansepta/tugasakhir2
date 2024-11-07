<div class="modal fade" id="editBarangMasukModal" aria-labelledby="editBarangMasukModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangMasukModal">Edit Data Barang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBarangMasukForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal Barang Masuk</label>
                        <input type="date" class="form-control" id="edit_tanggal" value="{{ now()->format('Y-m-d') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="edit_namaBarang" class="form-label">Nama Barang</label>
                        <select class="editNamaBarangSelect" id="edit_namaBarang" name="barang_id" required>
                            @foreach ($barang as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_barang }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_kategoriBarang" class="form-label">Kategori Barang</label>
                        <input type="string" class="form-control" id="edit_kategoriBarang" name="kategoriBarang" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="edit_satuanBarang" class="form-label">Satuan Barang</label>
                        <input type="string" class="form-control" id="edit_satuanBarang" name="satuanBarang" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="edit_hargaBeli" class="form-label">Harga Beli Barang</label>
                        <input type="number" class="form-control" id="edit_hargaBeli" name="harga_beli" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_jumlah" class="form-label">Jumlah Barang Masuk</label>
                        <input type="number" class="form-control" id="edit_jumlah" name="jumlah" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_harga_persatuan" class="form-label">Harga Beli Persatuan</label>
                        <input type="number" class="form-control" id="edit_hargaBeliSatuan" name="harga_persatuan" readonly>
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
    const edithargaBeliInput = document.getElementById('edit_hargaBeli');
    const editjumlahInput = document.getElementById('edit_jumlah');
    const edithargaBeliSatuanInput = document.getElementById('edit_hargaBeliSatuan');

    function edithitungHargaBeliSatuan() {
        const edithargaBeli = parseInt(edithargaBeliInput.value) || 0;
        const editjumlah = parseInt(editjumlahInput.value) || 0;
        const edithargaBeliSatuan = edithargaBeli / editjumlah;
        edithargaBeliSatuanInput.value = edithargaBeliSatuan;
    }

    edithargaBeliInput.addEventListener('input', edithitungHargaBeliSatuan);
    editjumlahInput.addEventListener('input', edithitungHargaBeliSatuan);
</script>