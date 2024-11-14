<div class="modal fade" id="tambahBarangKeluarModal" aria-labelledby="tambahBarangKeluarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBarangKeluarModal">Tambah Data Barang Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('manage.store-barangkeluar') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Barang Keluar</label>
                        <input type="date" class="form-control" id="tanggal" value="{{ now()->format('Y-m-d') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="namaBarang" class="form-label">Nama Barang</label>
                        <select class="namaBarangSelect" id="namaBarang" name="barang_id" required>
                            <option value="" disabled selected>Pilih Barang</option>
                            @foreach ($barang as $item)
                            <option value="{{$item->id}}">{{$item->nama_barang}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" id="karyawan_id" name="karyawan_id" value="{{Auth::user()->id}}">

                    <div class="mb-3">
                        <label for="kategoriBarang" class="form-label">Kategori Barang</label>
                        <input type="string" class="form-control" id="kategoriBarang" name="kategoriBarang" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="satuanBarang" class="form-label">Satuan Barang</label>
                        <input type="string" class="form-control" id="satuanBarang" name="satuanBarang" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="satuanTelur" class="form-label" id="satuanTelurLabel" style="display: none;">Satuan Telur</label>
                        <select class="form-control" id="satuanTelur" name="satuanTelur" style="display: none;">
                            <option value="" disabled selected>Pilih Satuan Telur</option>
                            <option value="kg">Kilogram</option>
                            <option value="peti">Peti</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jumlahPeti" class="form-label" id="jumlahPetiLabel" style="display: none;">Jumlah Peti</label>
                        <input type="number" class="form-control" id="jumlahPeti" name="jumlahPeti" style="display: none;">
                    </div>

                    <div class="mb-3">
                        <label for="jumlahKeluar" class="form-label">Jumlah Barang Keluar</label>
                        <input type="number" class="form-control" id="jumlahKeluar" name="jumlahKeluar" required>
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
    const jumlahPetiInput = document.getElementById('jumlahPeti');
    const jumlahInput = document.getElementById('jumlahKeluar');

    function hitungTotalBarangMasukTelur() {
        const jumlahPeti = parseInt(jumlahPetiInput.value) || 0;
        jumlahInput.value = jumlahPeti * 15;
    }

    jumlahPetiInput.addEventListener('input', hitungTotalBarangMasukTelur);

    $(document).ready(function() {
        $('.namaBarangSelect').select2({
            width: '100%',
            dropdownParent: $("#tambahBarangKeluarModal"),
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
            console.log(id);
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

                            let kategori = data.kategori;
                            console.log(kategori);
                            if (kategori === 'Telur') {
                                $('#satuanTelur').show();
                                $('#satuanTelurLabel').show();

                                // Tambahkan event listener pada #satuanTelur
                                $('#satuanTelur').on('change', function() {
                                    if ($(this).val() === 'peti') {
                                        $('#jumlahPeti').show();
                                        $('#jumlahPetiLabel').show();
                                    } else {
                                        $('#jumlahPeti').hide().val('');
                                        $('#jumlahPetiLabel').hide();
                                    }
                                });
                            } else {
                                $('#satuanTelur').hide().val('');
                                $('#satuanTelurLabel').hide();
                            }
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