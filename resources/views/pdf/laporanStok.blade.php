<!DOCTYPE html>
<html>

<head>
    <title> Laporan Penjualan </title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin-top: 2cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        .rangkasurat {
            width: 100%;
            max-width: 297mm;
            /* A4 landscape width */
            margin: 0 auto;
            background-color: #fff;
            padding: 5px;
            height: auto;
        }

        .tengah {
            text-align: center;
            line-height: 5px;
        }

        .table {
            border-bottom: 3px solid #000;
            padding: 2px;
            margin: 0 auto;
        }

        .table-container {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .foreach-border td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .full-width-table {
            width: 100%;
            border-collapse: collapse;
        }

        .full-width-table th,
        .full-width-table td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            font-size: 15px;
        }

        .small-border {
            border: 0.5px solid black;
            /* Border yang lebih kecil */
        }

        /* Set A4 landscape */
        @page {
            size: A4 landscape;
            margin: 0mm;
        }
    </style>

</head>

<body>
    <div class="rangkasurat">
        <table class="table" width="100%">
            <tr>
                <td class="tengah">
                    <h1>Toko Kurnia Telur</h1>
                    <a>Jl. Perumnas Raya No.7 4, RT.4/RW.2, Malaka Sari, Kec. Duren Sawit, Kota Jakarta Timur,</a><br>
                    <a style="margin-top: 18px;margin-bottom: 10px;display: inline-block;">Jakarta 13460</a>
                </td>
            </tr>
        </table>
        <div style="text-align:center; margin-top: 20px;">
            <h2>Laporan Stok Barang</h2>
        </div>
        @if ($laporanStok->isNotEmpty())
        <section>
            <div>
                <div>
                    <p><strong>Tanggal :</strong>
                        <span>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</span>
                    </p>
                </div>
            </div>
        </section>
        <!-- Wrapping the table in a div to center it -->
        <div>
            <table class="full-width-table">
                <thead>
                    <tr>
                        <th class="small-border">ID</th>
                        <th>Nama Barang</th>
                        <th class="small-border">Satuan</th>
                        <th class="small-border">Stok Awal</th>
                        <th class="small-border">In</th>
                        <th class="small-border">Out</th>
                        <th class="small-border">Stok Akhir</th>
                        <th class="small-border">Stok Gudang</th>
                        <th class="small-border">Stok Minus</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanStok as $laporan)
                    <tr>
                        <td>{{ $laporan->barang->id }}</td>
                        <td>{{ $laporan->barang->nama_barang }}</td>
                        <td>{{ $laporan->barang->satuan->satuan }}</td>
                        <td>{{ $laporan->stok_awal }}</td>
                        <td>{{ $laporan->stok_masuk }}</td>
                        <td>{{ $laporan->stok_keluar }}</td>
                        <td>{{ $laporan->stok_akhir }}</td>
                        <td>{{ $laporan->stok_gudang }}</td>
                        <td>{{ $laporan->stok_minus }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center text-mute" colspan="9">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</body>

</html>