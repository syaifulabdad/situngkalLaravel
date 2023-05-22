<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('media/img/logo-tanjabar.jpg') }}" rel="icon">
    <?php if (isset($dataPdf)) { ?>
        <title>LAPORAN <?= $title ?> BULAN <?= strtoupper(($bulan)) ?> TAHUN <?= $tahun ?></title>
    <?php } ?>

    <style>
        body {
            font-size: 11px !important;
            font-family: "Arial Narrow", Arial, sans-serif !important;
        }

        .header {
            font-size: 16px !important;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .header th {
            border: 0px !important;
        }

        .ttd td {
            border: none !important;
            font-size: 14px !important;
            text-align: left !important;
        }

        table th,
        td {
            border: 0.5px solid black !important;
            padding-left: 3px !important;
            padding-right: 3px !important;
            text-align: center !important;
            border-radius: 0 !important;
            /* font-family: Arial, Helvetica, sans-serif !important; */
        }

        .page-break {
            page-break-before: always !important;
        }

        @media print {
            .page-break {
                page-break-before: always !important;
            }
        }
    </style>
</head>

<body>
    <div id="bobot-nilai">
        <?php
        include 'laporan_tpp_bobot_nilai.php';
        ?>
    </div>

    <div id="perhitungan-tpp">
        <?php
        //include 'laporan_tpp_perhitungan.php'; 
        ?>
    </div>

    <div id="pajak">
        <?php
        include 'laporan_tpp_pajak.php';
        ?>
    </div>

    <div id="rekap">
        <?php
        include 'laporan_tpp_rekap.php';
        ?>
    </div>
</body>

</html>