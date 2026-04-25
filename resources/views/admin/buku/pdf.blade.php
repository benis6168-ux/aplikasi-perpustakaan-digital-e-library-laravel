<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Buku</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb; /* Warna biru sesuai tema admin */
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            text-transform: uppercase;
            color: #2563eb;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background-color: #f8fafc;
            color: #475569;
            text-align: left;
            padding: 12px 10px;
            border: 1px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }
        table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 10px;
            color: #94a3b8;
        }
        .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Daftar Katalog Buku</h2>
        <p>Libris Digital Library | Laporan Inventaris Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="50%">Judul Buku</th>
                <th width="30%">Penulis</th>
                <th width="15%" class="text-center">Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buku as $key => $b)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>
                    <span class="fw-bold">{{ $b->judul }}</span>
                </td>
                <td>{{ $b->penulis }}</td>
                <td class="text-center">{{ $b->stok }} unit</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->username ?? 'Admin' }}</p>
        <p class="page-number"></p>
    </div>

</body>
</html>
