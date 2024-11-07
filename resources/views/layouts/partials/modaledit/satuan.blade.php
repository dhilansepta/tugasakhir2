<div class="modal fade" id="editSatuanModal" tabindex="-1" aria-labelledby="editSatuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSatuanModal">Edit Data Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSatuanForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="edit_satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="edit_satuan" name="satuan" required>
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