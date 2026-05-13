<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Resi Setoran #{{ $deposit->id }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Font struk */
            background: #fff;
            color: #000;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .info-table { width: 100%; margin-bottom: 20px; font-size: 14px; }
        .info-table td { padding: 5px 0; vertical-align: top; }
        .label { font-weight: bold; width: 130px; }
        
        .box-data {
            border: 2px solid #000;
            padding: 15px;
            margin: 15px 0;
        }
        .big-number { font-size: 24px; font-weight: bold; margin: 10px 0; text-align: center; }
        
        .rincian-table { width: 100%; font-size: 14px; margin-top: 10px; }
        .rincian-table td { padding: 3px 0; }
        .total-row { border-top: 1px dashed #000; font-weight: bold; font-size: 16px; }
        .total-row td { padding-top: 10px; }

        .footer { margin-top: 40px; text-align: right; font-size: 12px; }
        .ttd-line { border-top: 1px solid #000; width: 150px; display: inline-block; margin-top: 50px; }

        @media print {
            .no-print { display: none; }
        }
        .btn-print {
            background: #000; color: #fff; padding: 10px 20px; 
            text-decoration: none; font-weight: bold; border-radius: 5px; cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" class="btn-print">🖨️ CETAK RESI</button>
    </div>

    <div class="header">
        <h1>RESIGUDANG OFFICIAL</h1>
        <p>Bukti Penyerahan Hasil Panen</p>
        <p>{{ now()->format('d F Y H:i') }}</p>
    </div>

    <table class="info-table">
        <tr><td class="label">NO. RESI</td><td>: <strong>#RG-{{ str_pad($deposit->id, 6, '0', STR_PAD_LEFT) }}</strong></td></tr>
        <tr><td class="label">PETANI</td><td>: {{ $deposit->user->name ?? 'Unknown' }}</td></tr>
        <tr><td class="label">TANGGAL</td><td>: {{ \Carbon\Carbon::parse($deposit->deposit_date)->format('d M Y') }}</td></tr>
    </table>

    <div class="box-data">
        <div style="font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 10px; text-align: center;">DETAIL BARANG</div>
        <table width="100%">
            <tr>
                <td align="left">{{ $deposit->coffee_variant }} ({{ $deposit->coffee_form }})</td>
                <td align="right" style="font-size: 18px; font-weight: bold;">
                    {{ number_format($deposit->weight_verified ?? $deposit->weight_input) }} Kg
                </td>
            </tr>
        </table>
    </div>

    @if($deposit->status != 'PENDING' && $deposit->status != 'REJECTED')
    <div class="box-data" style="background: #fcfcfc;">
        <div style="font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 10px; text-align: center;">RINCIAN PEMBAYARAN</div>
        
        <table class="rincian-table">
            <tr>
                <td>Harga Satuan / Kg</td>
                <td align="right">Rp {{ number_format($deposit->price_base_dp, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Nilai Barang (Estimasi)</td>
                <td align="right">Rp {{ number_format(($deposit->weight_verified * $deposit->price_base_dp), 0, ',', '.') }}</td>
            </tr>
            
            <tr><td colspan="2"><br></td></tr> <tr class="total-row">
                <td>
                    PEMBAYARAN TAHAP 1 (DP)<br>
                    <small style="font-weight: normal;">Persentase: {{ $deposit->dp_percentage }}%</small>
                </td>
                <td align="right">
                    Rp {{ number_format($deposit->total_dp_amount, 0, ',', '.') }}
                </td>
            </tr>

            @if($deposit->status == 'PAID_OFF')
            <tr>
                <td>PEMBAYARAN TAHAP 2 (LUNAS)</td>
                <td align="right">Rp {{ number_format($deposit->total_final_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endif

    <div style="text-align: center; margin: 20px 0; border: 2px dashed #000; padding: 10px;">
        STATUS: 
        @if($deposit->status == 'PENDING')
            <span style="font-weight: bold; color: orange;">MENUNGGU VERIFIKASI</span>
        @elseif($deposit->status == 'REJECTED')
            <span style="font-weight: bold; color: red;">DITOLAK</span>
        @elseif($deposit->status == 'PAID_OFF')
            <span style="font-weight: bold; color: green;">LUNAS (FULL PAID)</span>
        @else
            <span style="font-weight: bold;">DP SUDAH DIBAYAR</span>
        @endif
    </div>

    <div class="footer">
        <table width="100%">
            <tr>
                <td align="center" width="50%">
                    <p>Penyetor,</p>
                    <div class="ttd-line"></div>
                    <p><strong>{{ $deposit->user->name }}</strong></p>
                </td>
                <td align="center" width="50%">
                    <p>Petugas Validasi,</p>
                    <div class="ttd-line"></div>
                    <p><strong>{{ Auth::user()->name }}</strong></p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>