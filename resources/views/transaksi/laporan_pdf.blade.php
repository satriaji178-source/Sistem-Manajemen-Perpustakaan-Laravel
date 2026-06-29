<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Perpustakaan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
        .header h2 { margin: 0 0 5px 0; color: #28a745; }
        .header p { margin: 0; color: #666; font-size: 13px; }
        
        .summary-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .summary-box { background: #f8f9fa; border: 1px solid #ddd; padding: 10px; font-size: 13px; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background-color: #343a40; color: white; padding: 8px; text-align: left; }
        .data-table td { padding: 8px; border-bottom: 1px solid #ddd; }
        .data-table tr:nth-child(even) { background-color: #f2f2f2; }
        
        .text-end { text-align: right; }
        .badge-success { color: #155724; background-color: #d4edda; padding: 3px 7px; border-radius: 3px; font-weight: bold; }
        .badge-warning { color: #856404; background-color: #fff3cd; padding: 3px 7px; border-radius: 3px; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #aaa; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN TRANSAKSI PERPUSTAKAAN</h2>
        <p>Budi Santoso - Sistem Perpustakaan Berbasis Web</p>
        <p style="font-size: 10px; margin-top: 5px;">Dicetak pada: {{ now()->format('d M Y H:i') }} WIB</p>
    </div>

    <table class="summary-table">
        <tr>
            <td class="summary-box" style="width: 50%;">
                <strong>Total Transaksi:</strong> {{ $totalTransaksi }} Data
            </td>
            <td class="summary-box" style="width: 50%; color: #dc3545;">
                <strong>Total Akumulasi Denda:</strong> Rp {{ number_format($totalDenda, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">Kode</th>
                <th style="width: 20%">Nama Peminjam</th>
                <th style="width: 25%">Buku</th>
                <th style="width: 12%">Tgl Pinjam</th>
                <th style="width: 12%">Tenggat</th>
                <th style="width: 11%">Status</th>
                <th style="width: 15%" class="text-end">Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-weight: bold; color: #28a745;">{{ $item->kode_transaksi }}</td>
                <td>{{ $item->anggota->nama ?? '-' }}</td>
                <td>{{ $item->buku->judul ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}</td>
                <td>
                    @if($item->status == 'Dikembalikan')
                        <span class="badge-success">Kembali</span>
                    @else
                        <span class="badge-warning">Dipinjam</span>
                    @endif
                </td>
                <td class="text-end" style="font-weight: bold;">
                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Halaman otomatis dari sistem perpustakaan.
    </div>

</body>
</html>