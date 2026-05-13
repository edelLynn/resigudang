<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Resi Gudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">☕ Sistem Resi Gudang</h2>

    @if(session('success'))
        <div class="card border-success mb-4">
            <div class="card-header bg-success text-white">✅ {{ session('success') }}</div>
            <div class="card-body">
                @php $data = session('data_transaksi'); @endphp
                <p><strong>Total Aset:</strong> {{ $data['total_aset'] }}</p>
                <p><strong>DP ({{ $data['dp_persen'] }}):</strong> <span class="fs-4 fw-bold text-success">{{ $data['dp_rupiah'] }}</span></p>
                <p><strong>Sisa Aset:</strong> {{ $data['sisa_aset'] }}</p>
                <hr>
                
                @if($data['metode'] == 'MANUAL')
                    <div class="alert alert-warning text-center">
                        <strong>Transfer ke BCA: 888-123-4567 (PT Resi Gudang)</strong>
                    </div>
                @else
                    <div class="text-center">
                        <a href="{{ $data['link_bayar'] }}" target="_blank" class="btn btn-primary">👉 BAYAR SEKARANG</a>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/simpan-resi" method="POST">
                @csrf @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label>Nama Petani</label>
                    <input type="text" name="nama_petani" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Kopi</label>
                    <select name="jenis_kopi" class="form-select">
                        <option value="Robusta">Robusta</option>
                        <option value="Arabika">Arabika</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Berat (Kg)</label>
                        <input type="number" name="berat_total_kg" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Harga Pasar (Rp)</label>
                        <input type="number" name="harga_saat_ini" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3 p-3 bg-info bg-opacity-10 border border-info rounded">
                    <label class="fw-bold">Persentase DP (Max 60)</label>
                    <input type="number" name="persentase_dp" class="form-control" max="60" required>
                    <small class="text-danger">*Diatas 60% ditolak sistem</small>
                </div>

                <div class="mb-3">
                    <label>Metode Bayar</label>
                    <select name="metode_pembayaran" class="form-select">
                        <option value="MANUAL">Manual</option>
                        <option value="GATEWAY_AUTO">Payment Gateway</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold">PROSES RESI</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>