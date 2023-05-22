<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= asset('media/img/logo-tanjabar.png') ?>" rel="icon" type="image/png">
    <?php if (isset($pdf)) { ?>
        <title>LAPORAN <?= $title ?> BULAN <?= strtoupper($baseModel->bulan($bulan)) ?> TAHUN <?= $tahun ?></title>
    <?php } ?>

    <style>
        body {
            margin-left: 30px !important;
            margin-right: 20px !important;
            font-size: 11px !important;
            font-family: "Times New Roman" !important;
        }

        .header th {
            font-size: 16px !important;
            font-weight: bold !important;
            text-align: center !important;
            margin-bottom: 10px !important;
            border: 0px solid white !important;
        }

        .sub-table th {
            padding: 2px !important;
            font-size: 9px !important;
            text-align: center !important;
            border: 1px solid black !important;
        }

        .jumlah {
            padding: 2px !important;
            text-align: center !important;
            border: 1px solid black !important;
            padding-bottom: 8px !important;
        }


        td {
            font-size: 16px !important;
            text-align: justify !important;
            border-radius: 0 !important;
            line-height: 2 !important;
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
    <table width="100%" class="header">
        <tr>
            <th style="vertical-align: top !important;" width="85px" rowspan="2"><img src="<?= $logoBase64  ?>" width="100%"></th>
            <th style="font-size: 18px !important;">
                PEMERINTAH KABUPATEN TANJUNG JABUNG BARAT<br>
                <span style="font-size: 20px !important;">DINAS PENDIDIKAN DAN KEBUDAYAAN</span>
            </th>
        </tr>
        <?php if ($getSekolah) { ?>
            <tr>
                <th style="font-size: 20px !important;">
                    <span style="font-size: 22px !important;"><?= strtoupper($getSekolah->nama) ?></span><br>
                    <?= strtoupper(str_replace('Kec.', 'KECAMATAN', $getSekolah->wilayah->nama)) ?>
                </th>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="2" style="border-bottom: solid 3px !important;"></td>
        </tr>
    </table>
    <br>
    <table width="100%" class="header">
        <tr>
            <th colspan="2"><u>SURAT TANGGUNG JAWAB MUTLAK</u><br><br></th>
        </tr>
        <tr>
            <td colspan="2">Yang bertanda tangan dibawah ini :</td>
        </tr>
        <tr>
            <td style="line-height: 1.2 !important;" width="150px">Nama</td>
            <td style="line-height: 1.2 !important;">: <?= $kepsek ? $kepsek->nama : null ?></td>
        </tr>
        <tr>
            <td style="line-height: 1.2 !important;">NIP</td>
            <td style="line-height: 1.2 !important;">: <?= $kepsek ? $kepsek->nip : null ?></td>
        </tr>
        <tr>
            <td style="line-height: 1.2 !important;">Jabatan</td>
            <td style="line-height: 1.2 !important;">: Kepala Sekolah</td>
        </tr>
        <tr>
            <td style="line-height: 1.2 !important;">Unit Kerja</td>
            <td style="line-height: 1.2 !important;">: <?= $getSekolah->nama ?></td>
        </tr>
        <tr>
            <td colspan="2"><br></td>
        </tr>
        <tr>
            <td colspan="2">Menyatakan dengan ini sesungguhnya bahwa :</td>
        </tr>
        <tr>
            <td colspan="2">
                <ol>
                    <li>Pada hari <b><?= strtoupper($baseModel->nama_hari(date('Y-m-d', strtotime($tanggal_cetak)))) ?></b> Tanggal <b><?= strtoupper($baseModel->nomor_text(date('d', strtotime($tanggal_cetak)))) ?></b> Bulan <b><?= strtoupper($baseModel->bulan(date('m', strtotime($tanggal_cetak)))) ?></b> Tahun <b><?= strtoupper($baseModel->nomor_text(date('Y', strtotime($tanggal_cetak)))) ?></b> tidak dapat menggunakan Aplikasi TPP/ Mesin Absensi Elektronik dikarenakan terjadinya gangguan.</li>
                    <li>Adapun Pembayaran TPP akan disesuaikan dengan Kehadiran / Laporan TPP Manual</li>
                    <li>Apabila dikemudian hari terdapat kesalahan dan atau kelebihan atas pembayaran dimaksud, Kami bertanggung Jawab sepenuhnya dan bersedia mengembalikan kelebihan / kesalahan dimaksud kepada Kas Negara sesuai dengan peraturan dan perundang-undangan yang berlaku.</li>
                </ol>
            </td>
        </tr>
        <tr>
            <td colspan="2">Demikian Pernyataan ini kami buat dengan sebenarnya benarnya.</td>
        </tr>
    </table>

    <br>
    <div class="ttd">
        <table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
            <tr>
                <td width="50%"></td>
                <td colspan="3">Kuala Tungkal, <?= $tanggal_cetak ? $baseModel->tgl_indo($tanggal_cetak) : $baseModel->tgl_indo(date('Y-m-d')) ?></td>
            </tr>
            <tr>
                <td></td>
                <?php if ($getSekolah) { ?>
                    <td colspan="3">KEPALA SEKOLAH,</td>
                <?php } ?>
            </tr>
            <tr>
                <td></td>
                <?php if ($getSekolah) { ?>
                    <td colspan="3" style="padding-top: 65px !important; vertical-align: bottom !important;">
                        <b><?= $kepsek ? $kepsek->nama : "_____________________" ?></b><br>
                        NIP. <?= $kepsek ? $kepsek->nip : null ?>
                    </td>
                <?php } ?>
            </tr>
        </table>
    </div>
    <div class="page-break"></div>

    <table width="100%" class="header">
        <tr>
            <th style="vertical-align: top !important;" width="85px" rowspan="2"><img src="<?= $logoBase64  ?>" width="100%"></th>
            <th style="font-size: 18px !important;">
                PEMERINTAH KABUPATEN TANJUNG JABUNG BARAT<br>
                <span style="font-size: 20px !important;">DINAS PENDIDIKAN DAN KEBUDAYAAN</span>
            </th>
        </tr>
        <?php if ($getSekolah) { ?>
            <tr>
                <th style="font-size: 20px !important;">
                    <span style="font-size: 22px !important;"><?= strtoupper($getSekolah->nama) ?></span><br>
                    <?= strtoupper(str_replace('Kec.', 'KECAMATAN', $getSekolah->wilayah->nama)) ?>
                </th>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="2" style="border-bottom: solid 3px !important;"></td>
        </tr>
    </table>
    <br>
    <table width="100%" class="header">
        <tr>
            <th><u>SURAT TANGGUNG JAWAB MUTLAK</u><br><br></th>
        </tr>
        <tr>
            <td>Saya yang bertanda tangan dibawah ini selaku Kepala <?= strtoupper($getSekolah->nama) ?> <?= str_replace('Kec.', 'Kecamatan', $getSekolah->nama_wilayah) ?> Kab. Tanjung Jabung Barat, dengan ini menyampaikan Jumlah Guru Penerima Tunjangan disekolah kami untuk keperluan penghitungan TPP bulan <?= strtoupper($baseModel->bulan("$bulan")) ?> <?= $tahun ?></td>
        </tr>
        <tr>
            <td>
                <br>
                <table width="100%" class="sub-table" border-radius="0" cellspacing="0">
                    <tr>
                        <th style="line-height: 1.5 !important;">JUMLAH GURU SESUAI AMPERA GAJI BULAN <?= strtoupper($baseModel->bulan("$bulan")) ?> <?= $tahun ?></th>
                        <th style="line-height: 1.5 !important;">JUMLAH GURU PENERIMA TUNJANGAN PROFESI/ SERTIFIKASI BULAN <?= strtoupper($baseModel->bulan("$bulan")) ?> <?= $tahun ?></th>
                        <th style="line-height: 1.5 !important;">JUMLAH GURU PENERIMA PROFESI/ SERTIFIKASI dari DEPAG BULAN <?= strtoupper($baseModel->bulan("$bulan")) ?> <?= $tahun ?></th>
                        <th style="line-height: 1.5 !important;">JUMLAH GURU PENERIMA TUNJANGAN TAMSIL BULAN <?= strtoupper($baseModel->bulan("$bulan")) ?> <?= $tahun ?></th>
                        <th style="line-height: 1.5 !important;">JUMLAH GURU PENERIMA TUNJANGAN NON TAMSIL DAN NON SERTI BULAN <?= strtoupper($baseModel->bulan("$bulan")) ?> <?= $tahun ?></th>
                        <th style="line-height: 1.5 !important;">JUMLAH GURU YANG TIDAK BERHAK MENERIMA TPP SESUAI PERBUB THN 2021 BULAN <?= strtoupper($baseModel->bulan("$bulan")) ?> <?= $tahun ?></th>
                    </tr>
                    <?php
                    // $tenagaNonPns = $model->penerimaTpp(['status_kepegawaian_id' => 4]);
                    // $tenagaKontrak = $model->penerimaTpp(['status_kepegawaian_id' => 3]);
                    $PNS[] = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'status_kepegawaian_id' => 1]);
                    $PNS[] = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'status_kepegawaian_id' => 2]);
                    $PNS[] = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'status_kepegawaian_id' => 3]);
                    $PNS[] = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'status_kepegawaian_id' => 10]);

                    $getTpp = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'jenis_tpp_id' => '992e1fbb-9079-493d-bed8-6611272bbd9a']);
                    $getSerti = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'sertifikasi' => 1, 'bidang_studi_id' => 0]);
                    $getSertiKemenag = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'sertifikasi' => 1, 'bidang_studi_id' => 1]);
                    $getSertiKemenag2 = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'sertifikasi' => 1, 'status_kepegawaian_id' => 3]);

                    $getTamsil = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'sertifikasi' => 0, 'jenis_tpp_id' => '99374f5a-fade-4d09-b257-f3219c6f0485']);
                    $getNonser = $model->penerimaTpp(['sekolah_id' => $sekolah_id, 'sertifikasi' => 0, 'jenis_tpp_id' => '992e1fcc-2a79-4529-b03c-5bca117ea8d8']);
                    ?>
                    <tr>
                        <td class='jumlah'><?= $getTpp ?> Orang</td>
                        <td class='jumlah'><?= $getSerti ?> Orang</td>
                        <td class='jumlah'><?= ($getSertiKemenag + $getSertiKemenag2) ?> Orang</td>
                        <td class='jumlah'><?= $getTamsil ?> Orang</td>
                        <td class='jumlah'><?= $getNonser ?> Orang</td>
                        <td class='jumlah'><?= (array_sum($PNS) - ($getSerti + $getSertiKemenag + $getSertiKemenag2 + $getTamsil)) ?> Orang</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><i>*Terlampir kami sampaikan copy rekap ampera gaji bulan bersangkutan ( dalam kertas HVS ).</i><br><br></td>
        </tr>
        <tr>
            <td>Demikian daftar ini kami sampaikan, dan kami bertanggung jawab atas kebenaran daftar tersebut diatas.</td>
        </tr>
    </table>

    <br>
    <div class="ttd">
        <table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
            <tr>
                <td width="50%"></td>
                <td colspan="3">Kuala Tungkal, <?= $tanggal_cetak ? $baseModel->tgl_indo($tanggal_cetak) : $baseModel->tgl_indo(date('Y-m-d')) ?></td>
            </tr>
            <tr>
                <td></td>
                <?php if ($getSekolah) { ?>
                    <td colspan="3">KEPALA SEKOLAH,</td>
                <?php } ?>
            </tr>
            <tr>
                <td></td>
                <?php if ($getSekolah) { ?>
                    <td colspan="3" style="padding-top: 65px !important; vertical-align: bottom !important;">
                        <b><?= $kepsek ? $kepsek->nama : "_____________________" ?></b><br>
                        NIP. <?= $kepsek ? $kepsek->nip : null ?>
                    </td>
                <?php } ?>
            </tr>
        </table>
    </div>
</body>

</html>