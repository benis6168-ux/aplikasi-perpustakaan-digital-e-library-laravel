<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Peminjaman</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            text-transform: uppercase;
            color: #1a5cff;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background-color: #f2f7ff;
            color: #333;
            text-align: left;
            padding: 12px;
            border: 1px solid #dee2e6;
            text-transform: uppercase;
            font-size: 10px;
        }
        table td {
            padding: 10px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            display: inline-block;
            text-transform: uppercase;
        }
        /* Styling warna status manual untuk PDF */
        .status-dikembalikan { background-color: #d1e7dd; color: #0f5132; }
        .status-dipinjam { background-color: #fff3cd; color: #664d03; }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Peminjaman Buku</h2>
        <p>E-Perpus Digital | Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Pengguna</th>
                <th>Judul Buku</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $p)
            <tr>
                <td style="text-align: center;">{{ $key + 1 }}</td>
                <td>
                    <strong>{{ $p->user->username }}</strong><br>
                    <small style="color: #888;">{{ $p->user->email }}</small>
                </td>
                <td>{{ $p->buku->judul }}</td>
                <td>
                    {{-- Logika warna status --}}
                    @php
                        $statusClass = $p->status_peminjaman == 'dikembalikan' ? 'status-dikembalikan' : 'status-dipinjam';
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        {{ $p->status_peminjaman }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem Perpustakaan Digital &copy; {{ date('Y') }}
    </div>

</body>
</html>
