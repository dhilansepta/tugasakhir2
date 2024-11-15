<div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="editBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangModal">Edit Data Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBarangForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="edit_nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_kategori_id" class="form-label">Kategori</label>
                        <select class="form-select" id="edit_kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_satuan_id" class="form-label">Satuan</label>
                        <select class="form-select" id="edit_satuan_id" name="satuan_id" required>
                            <option value="">Pilih Satuan</option>
                            @foreach ($satuan as $item)
                            <option value="{{ $item->id }}">{{ $item->satuan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_harga_beli" class="form-label">Harga Beli Persatuan</label>
                        <input type="number" class="form-control" id="edit_harga_beli" name="harga_beli" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_harga_jual" class="form-label">Harga Jual Persatuan</label>
                        <input type="number" class="form-control" id="edit_harga_jual" name="harga_jual" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_keuntungan" class="form-label">Keuntungan Persatuan (Tidak boleh 0 atau < 0)</label>
                        <input type="number" class="form-control" id="edit_keuntungan" name="keuntungan" readonly>
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