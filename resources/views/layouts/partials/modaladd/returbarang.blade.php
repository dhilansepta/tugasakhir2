<div class="modal fade" id="tambahReturBarangModal" aria-labelledby="tambahReturBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahReturBarangModal">Tambah Data Barang Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('manage.store-returbarang') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="namaBarang" class="form-label">Nama Barang</label>
                        <select class="namaBarangSelect" id="namaBarang" name="barang_id" required>
                            <option value="" disabled selected>Pilih Barang</option>
                            @foreach ($barang as $item)
                            <option value="{{$item->id}}">{{$item->nama_barang}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kategoriBarang" class="form-label">Kategori Barang</label>
                        <input type="string" class="form-control" id="kategoriBarang" name="kategoriBarang" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="satuanBarang" class="form-label">Satuan Barang</label>
                        <input type="string" class="form-control" id="satuanBarang" name="satuanBarang" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Barang</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="" disabled selected>Status Barang</option>
                            <option value="expired">Expired</option>
                            <option value="rusak">Rusak</option>
                            <option value="dikembalikan">Di Kembalikan</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.namaBarangSelect').select2({
            width: '100%',
            dropdownParent: $("#tambahReturBarangModal"),
            ajax: {
                url: "{{ route('selectbarang') }}",
                dataType: 'json',
                delay: 250, // Delay for requests to prevent too many requests
                data: function(params) {
                    return {
                        q: params.term // Search term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.results // `results` key should match the key returned by the controller
                    };
                }
            }
        });

        $('#namaBarang').on('change', function() {
            let id = $(this).val();

            if (id) {
                $.ajax({
                    url: "{{ url('selectbarang') }}/" + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            $('#kategoriBarang').val(data.kategori);
                            $('#satuanBarang').val(data.satuan);
                        }
                    },
                    error: function() {
                        alert('Failed to fetch data.');
                    }
                });
            } else {
                $('#kategoriBarang').val('');
                $('#satuanBarang').val('');
            }
        });
    });
</script>