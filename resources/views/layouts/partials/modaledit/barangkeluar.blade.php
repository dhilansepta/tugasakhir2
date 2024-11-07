<div class="modal fade" id="editBarangKeluarModal" aria-labelledby="editBarangKeluarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangKeluarModal">Edit Data Barang Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBarangKeluarForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal Barang Keluar</label>
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

                    <input type="hidden" id="edit_karyawan_id" name="karyawan_id" value="{{Auth::user()->id}}">

                    <div class="mb-3">
                        <label for="edit_kategoriBarang" class="form-label">Kategori Barang</label>
                        <input type="string" class="form-control" id="edit_kategoriBarang" name="kategoriBarang" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="edit_satuanBarang" class="form-label">Satuan Barang</label>
                        <input type="string" class="form-control" id="edit_satuanBarang" name="satuanBarang" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="edit_jumlahKeluar" class="form-label">Jumlah Barang Keluar</label>
                        <input type="number" class="form-control" id="edit_jumlahKeluar" name="jumlahKeluar" required>
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