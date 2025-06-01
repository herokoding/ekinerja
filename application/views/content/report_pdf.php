<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kinerja</title>
    <style>
        /* CSS sederhana untuk PDF */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        h2, h3 {
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .subtitle {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #333;
            padding: 4px 6px;
            text-align: left;
            vertical-align: top;
        }
        table th {
            background: #f0f0f0;
            font-weight: bold;
        }
        /* Untuk cell tanggal yang di-rowspan */
        .tgl-cell {
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }
        /* Footer tanda tangan */
        .footer {
            margin-top: 20px;
        }
        .footer .ttd {
            width: 300px;
            float: right;
            text-align: center;
            line-height: 1.2;
        }
    </style>
</head>
<body>
    <!-- Judul Utama -->
    <h2>LAPORAN KINERJA PPNPN</h2>
    <h3>BADAN KEPEGAWAIAN NEGARA</h3>

    <!-- Subtitle (Periode & Nama/Jabatan) -->
    <div class="subtitle">
        <p style="font-size: 15px;">Periode: <strong><?= date('M Y', strtotime($periode['record_date'])) ?></strong></p>
        <?php if (! empty($profile)): ?>
            <p style="font-size: 15px;">Nama: <strong><?= $profile['user_fullname'] ?></strong>  &nbsp;|&nbsp; Jabatan: <strong><?= $profile['role_name'] ?></strong> &nbsp;|&nbsp; Unit: <strong><?= $profile['depart_name'] ?></strong></p>
        <?php endif; ?>
    </div>

    <!-- Tabel Utama -->
    <table>
        <thead>
            <tr>
                <th style="width:20%;">Tanggal</th>
                <th style="width:50%;">Uraian</th>
                <th style="width:15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($kinerjaList as $tgl => $items):
                $rowspan = count($items);
                $subIndex = 1;
                foreach ($items as $key => $item):
                    echo '<tr>';
                    // Kolom Tanggal, hanya baris pertama di grup
                    if ($key === 0) {
                        $formattedTgl = date('j M Y', strtotime($tgl));
                        echo '<td class="tgl-cell" rowspan="' . $rowspan . '">' . $formattedTgl . '</td>';
                    }
                    // Kolom Uraian Kinerja
                    echo '<td>' . htmlspecialchars($item['record_desc']) . '</td>';
                    
                    // Kolom Satuan (Kegiatan)
                    $statusText = 'Submitted';
                    if ($item['record_status'] == 1) {
                        $statusText = 'Approved';
                    } elseif ($item['record_status'] == 2) {
                        $statusText = 'Rejected';
                    }
                    echo "<td style='text-align:center;'>{$statusText}</td>";
                    echo '</tr>';
                endforeach;
            endforeach;
            ?>
        </tbody>
    </table>

    <!-- Footer (Tanda Tangan) -->
    <div class="footer">
        <div style="width: 50%; float: left;">
            <!-- Kosong, bisa digunakan keterangan lain jika perlu -->
        </div>
        <div class="ttd">
            <p>Jakarta, <?= date('d-m-Y') ?></p>
            <p>Mengetahui,</p>
            <br><br><br>
            <p><strong>EKA SANTOSA, S.Pd</strong></p>
            <p>NIP. 196609161990081001</p>
            <p>Kepala Sub Bagian Rumah Tangga</p>
        </div>
    </div>
</body>
</html>
