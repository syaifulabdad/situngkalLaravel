<div class="page-break"></div>
<div class="header">
    <table width="100%" border-radius="0" cellspacing="0">
        <tr>
            <th colspan="10">PERHITUNGAN TPP BERDASARKAN PERHITUNGAN OBJEKTIF LAINNYA ( UANG MAKAN )</th>
        </tr>
        <tr>
            <th colspan="10">DINAS PENDIDIKAN DAN KEBUDAYAAN</th>
        </tr>
        <tr>
            <th colspan="10">BULAN <?= strtoupper(($bulan)) ?> TAHUN <?= $tahun ?></th>
        </tr>
    </table>
</div>


<table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NAMA</th>
            <th rowspan="2">JABATAN</th>
            <th colspan="4" class="text-center">DISIPLIN HARIAN PEGAWAI</th>
            <th rowspan="2" class="text-center">PERSENTASE <br>DISIPLIN</th>
            <th rowspan="2" class="text-center">KETETAPAN JUMLAH <br>NILAI ASPEK DISIPLIN</th>
            <th rowspan="2" class="text-center">TPP ASPEK DISIPLIN<br>YANG DITERIMA</th>
        </tr>
        <tr>
            <td class="text-sm text-center">JUMLAH<br>HARI KERJA</td>
            <td class="text-sm text-center">JUMLAH<br>KETIDAK-<br>HADIRAN</td>
            <td class="text-sm text-center">JUMLAH</td>
            <td class="text-sm text-center">TOTAL<br>HAR KERJA</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="10" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important; font-size: 14px !important;"><?= $laporan_title ?></th>
        </tr>
        <tr>
            <td colspan="10">&nbsp;</td>
        </tr>

        <?php
        $no = 1;
        foreach ($getJabatanArray as $jabatan_id => $jabatan) { ?>
            <?php foreach ($getGolonganArray as $gol) {
                if ($jabatan_id == 1) { ?>
                    <tr>
                        <th colspan='10' style='text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important;'><?= ($gol ? "GOLONGAN $gol" : "GURU NON PNS") ?></th>
                    </tr>
                <?php } ?>

                <?php foreach ($model->getRekapTpp_array([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'jabatan_id' => $jabatan_id, // jabatan guru
                    'golongan' => $gol,
                    'jenis_tpp_id' => $jenis_tpp_id
                ]) as $tpp) {

                    $jumlahTidakHadir = $tpp->jumlah_alpa;
                    $jumlahHadir = $tpp->jumlah_hadir; ?>

                    <tr>
                        <td><?= $no ?></td>
                        <td style='text-align: left !important;'>
                            <?= $tpp->nama ?>
                            <small>
                                <?= $tpp->nip ? "<br>$tpp->nip" : null ?>
                                <?= $tpp->pangkat_golongan_id ? "<br>$tpp->pangkat_golongan" : null ?>
                            </small>
                        </td>
                        <td style='text-align: left !important;'>
                            <?= $tpp->jabatan_id >= 0 ? "$tpp->jabatan " : null ?>
                        </td>
                        <td><?= $tpp->jumlah_hari_kerja ?></td>
                        <td><?= ($jumlahTidakHadir > 0 ? $jumlahTidakHadir : 0) ?></td>
                        <td><?= $jumlahHadir ?></td>
                        <td><?= $jumlahHadir ?></td>
                        <td><?= $tpp->persentase_kehadiran ?>%</td>
                        <td><?= $dataExcel ? $tpp->jumlah_tpp_disiplin : number_format($tpp->jumlah_tpp_disiplin, 0, ',', '.') ?></td>
                        <td><?= $dataExcel ? $tpp->jumlah_tpp_disiplin : number_format($tpp->jumlah_tpp_disiplin, 0, ',', '.') ?></td>
                    </tr>
                <?php ++$no;
                }

                if ($jabatan_id == 1) { ?>
                    <tr>
                        <td colspan='10'>&nbsp;</td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <?php } ?>

    </tbody>
</table>


<br>
<div class="ttd">
    <table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
        <tr>
            <td colspan="7" style="width: 450px !important;"></td>
            <td colspan="3" style="text-align: left !important;">Kuala Tungkal, <?= $tanggal_cetak ? ($tanggal_cetak) : (date('Y-m-d')) ?></td>
        </tr>
        <tr>
            <td colspan="10">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="7"></td>
            <?php if ($getSekolah) { ?>
                <td colspan="3" style="text-align: left !important;"><?= "KEPALA $getSekolah->nama,"; ?></td>
            <?php } else { ?>
                <td colspan="3" style="text-align: left !important;"><?= "KEPALA $nama_instansi," ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="10">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="10">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="10">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="7"></td>
            <?php if ($getSekolah) { ?>
                <td colspan="3" style="vertical-align: bottom !important;">
                    <?= $getSekolah->nama_kepsek ? $getSekolah->nama_kepsek : "_____________________" ?>
                </td>
            <?php } else { ?>
                <td colspan="3" style="vertical-align: bottom !important;">
                    <?= $nama_kepala_dinas ? $nama_kepala_dinas : "_____________________" ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="7"></td>
            <?php if ($getSekolah) { ?>
                <td colspan="3">
                    NIP. <?= $getSekolah->nip_kepsek ?>
                </td>
            <?php } else { ?>
                <td colspan="3">
                    NIP. <?= $nip_kepala_dinas ?>
                </td>
            <?php } ?>
        </tr>
    </table>
</div>