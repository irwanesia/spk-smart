<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Perangkingan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">
    <div style="text-align: center; border: 10px">
        <img src="/img/logo.png" width="100" alt="">
    </div>

    <h2>Sistem Pendukung Keputusan Pemilihan Mobil</h2>
    <h4>Laporan Hasil Perangkingan Mobil</h4>
    <hr>

    <table>
        <tr>
            <td><strong>Nama Pelanggan</strong></td>
            <td><?= esc($user[0]['nama']) ?></td>
        </tr>
        <tr>
            <td><strong>Email</strong></td>
            <td><?= esc($user[0]['email']) ?></td>
        </tr>
        <tr>
            <td><strong>Tanggal Cetak</strong></td>
            <td><?= date('d-m-Y H:i') ?></td>
        </tr>
    </table>

    <h4 class="text-center" style="margin-top: 30px;">Hasil Perhitungan dan Rangking Mobil</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mobil</th>
                <th>Skor</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1 ?>
            <?php foreach ($hasil as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nama_mobil']) ?></td>
                    <td><?= number_format($row['skor'], 2) ?></td>
                    <td><?= $row['ranking'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <br><br>
    <div style="text-align: right;">
        <p>Dicetak pada: <?= date('d-m-Y H:i') ?></p>
        <br><br>
        <br><br>
        <p style="margin-right: 85px;">TTD</p>
    </div>


    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.history.back(); // Kembali ke halaman sebelumnya
            };
        };
    </script>

</body>

</html>