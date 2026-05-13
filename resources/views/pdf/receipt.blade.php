<!DOCTYPE html>
<html>
<head>
    <title>Resi Setoran #{{ $deposit->id }}</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; color: #666; }
        
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .label { font-weight: bold; width: 130px; }

        .total-box { border: 2px solid #333; padding: 15px; margin-top: 20px; text-align: right; }
        .total-label { font-size: 14px; text-transform: uppercase; font-weight: bold; }
        .total-value { font-size: 20px; font-weight: bold; color: #000; }

        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #aaa; }
        .stamp { margin-top: 30px; text-align: right; margin-right: 50px; }
        .stamp-box { border: 1px dashed #aaa; display: inline-block; padding: 10px 30px; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>BUKTI SETORAN GUDANG</h1>
        <p>ResiGudang Official Receipt • ID Transaksi: #RG-{{ $deposit->id }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Petani:</td>
            <td>{{ $deposit->user->name }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Setor:</td>
            <td>{{ \Carbon\Carbon::parse($deposit->deposit_date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Status:</td>
            <td><span style="text-transform: uppercase; font-weight: bold;">{{ str_replace('_', ' ', $deposit->status) }}</span></td>
        </tr>
    </table>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <table class="info-table">
        <tr>
            <td class="label">Jenis Kopi:</td>
            <td>{{ $deposit->coffee_variant }} ({{ $deposit->coffee_form }})</td>
        </tr>
        <tr>
            <td class="label">Berat Final:</td>
            <td>
                @if($deposit->weight_verified)
                    <strong>{{ number_format($deposit->weight_verified, 1) }} Kg</strong> (Terverifikasi)
                @else
                    {{ number_format($deposit->weight_input, 1) }} Kg (Estimasi)
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Jumlah Karung:</td>
            <td>{{ $deposit->bag_count }} Karung</td>
        </tr>
    </table>

    <div class="total-box">
        @if($deposit->status == 'PARTIAL_PAID')
            <div class="total-label">Total DP Dibayarkan</div>
            <div class="total-value">Rp {{ number_format($deposit->total_dp_amount, 0, ',', '.') }}</div>
            <div style="font-size: 10px; margin-top: 5px;">(Pelunasan Belum Selesai)</div>
        @elseif($deposit->status == 'PAID_OFF')
            <div class="total-label">Total Terima Bersih</div>
            <div class="total-value">Rp {{ number_format($deposit->total_dp_amount + $deposit->total_final_amount, 0, ',', '.') }}</div>
            <div style="font-size: 10px; margin-top: 5px; color: green;">(LUNAS)</div>
        @else
            <div class="total-label">Estimasi Nilai</div>
            <div class="total-value">Rp {{ number_format($deposit->weight_input * 12000, 0, ',', '.') }}</div>
            <div style="font-size: 10px; margin-top: 5px; color: orange;">(Menunggu Verifikasi)</div>
        @endif
    </div>

    <div class="stamp">
        <div class="stamp-box">
            <p style="font-weight: bold; margin-bottom: 30px;">Petugas Gudang</p>
            <p style="font-size: 10px;">( Tanda Tangan Digital )</p>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak otomatis oleh sistem ResiGudang pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>

</body>
</html>