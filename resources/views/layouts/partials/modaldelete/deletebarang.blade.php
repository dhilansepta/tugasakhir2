<div class="modal fade" id="deleteBarangModal" aria-labelledby="deleteBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBarangModal">Delete Data Barang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <form id="deleteBarangForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-success">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>