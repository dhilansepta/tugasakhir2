<div class="modal fade" id="editReturBarangModal" aria-labelledby="editReturBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReturBarangModal">Edit Data Retur Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReturBarangForm" method="POST" action="">
                    @csrf
                    @method('PUT')

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
                        <label for="edit_jumlah" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="edit_jumlah" name="jumlah" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status Barang</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="" disabled selected>Status Barang</option>
                            <option value="expired">Expired</option>
                            <option value="rusak">Rusak</option>
                            <option value="dikembalikan">Di Kembalikan</option>
                        </select>
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