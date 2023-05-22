<div class="header">
    <table width="100%" border-radius="0" cellspacing="0">
        <tr>
            <th colspan="8">KETETAPAN PERTIMBANGAN BOBOT PENILAIAN DISIPLIN</th>
        </tr>
        <tr>
            <th colspan="8">DINAS PENDIDIKAN DAN KEBUDAYAAN</th>
        </tr>
        <tr>
            <th colspan="8">BULAN <?= strtoupper($baseModel->bulan($bulan)) ?> TAHUN <?= $tahun ?></th>
        </tr>
    </table>
</div>

<table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NAMA</th>
            <th rowspan="2">TEMPAT TUGAS</th>
            <th colspan="2" class="text-center">KETETAPAN NILAI ASPEK</th>
            <th rowspan="2" class="text-center">KETETAPAN BESAR <br>TUNJANGAN/BULAN</th>
            <th rowspan="2" class="text-center">JUMLAH NILAI <br>ASPEK KINERJA</th>
            <th rowspan="2" class="text-center">JUMLAH NILAI <br>ASPEK DISIPLIN</th>
        </tr>
        <tr>
            <td class="text-sm text-center">KINERJA</td>
            <td class="text-sm text-center">DISIPLIN</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="8" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important; font-size: 14px !important;"><?= $laporan_title ?></th>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>

        <?php
        $no = 1;
        foreach ($getJabatanArray as $jabatan_id => $jabatan) {
            foreach ($getGolonganArray as $golKey => $golongan) { ?>
                <?php if ($jabatan_id == 1) { ?>
                    <tr>
                        <th colspan="8" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important;"><?= $golongan ? "GOLONGAN $golongan" : "GURU NON PNS" ?></th>
                    </tr>
                <?php } ?>

                <?php $no2 = 0;
                foreach ($model->getRekapTpp_array([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'jenis_ptk_id' => $jabatan_id, // jabatan guru
                    'golongan' => $golongan,
                    'jenis_tpp_id' => $jenis_tpp_id
                ]) as $tpp) { ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td style="text-align: left !important;">
                            <?= $tpp->nama ?>
                            <small>
                                <?= $tpp->nip ? "<br>$tpp->nip" : null ?>
                                <?= $tpp->pangkat_golongan ? "<br>$tpp->pangkat_golongan" : null ?>
                            </small>
                        </td>
                        <td style="text-align: left !important;">
                            <?= $tpp->nama_sekolah ? $tpp->nama_sekolah : null ?>
                        </td>
                        <td>-</td>
                        <td><?= $tpp->persentase_kehadiran ?>%</td>
                        <td><?= $dataExcel ? $tpp->tpp_perbulan : number_format($tpp->tpp_perbulan, 0, ',', '.') ?></td>
                        <td>-</td>
                        <td><?= $dataExcel ? $tpp->jumlah_tpp_disiplin : number_format($tpp->jumlah_tpp_disiplin, 0, ',', '.') ?></td>
                    </tr>
                <?php ++$no;
                } ?>
                <?php if ($jabatan_id == 1) { ?>
                    <tr>
                        <td colspan="8">&nbsp;</td>
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
            <td colspan="5" style="width: 450px !important;"></td>
            <td colspan="3" style="text-align: left !important;">Kuala Tungkal, <?= $tanggal_cetak ? $baseModel->tgl_indo($tanggal_cetak) : $baseModel->tgl_indo(date('Y-m-d')) ?></td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <?php if ($getSekolah) { ?>
                <td colspan="3" style="text-align: left !important;"><?= "KEPALA $getSekolah->nama,"; ?></td>
            <?php } else { ?>
                <td colspan="3" style="text-align: left !important;"><?= "KEPALA DINAS PENDIDIKAN DAN KEBUDAYAAN," ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <?php if ($getSekolah) { ?>
                <td colspan="3" style="vertical-align: bottom !important;">
                    <?= $kepsek ? $kepsek->nama : "_____________________" ?>
                </td>
            <?php } else { ?>
                <td colspan="3" style="vertical-align: bottom !important;">
                    <?= $nama_kepala_dinas ? $nama_kepala_dinas : "_____________________" ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="5"></td>
            <?php if ($getSekolah) { ?>
                <td colspan="3">
                    NIP. <?= $kepsek ? $kepsek->nip : null ?>
                </td>
            <?php } else { ?>
                <td colspan="3">
                    NIP. <?= $nip_kepala_dinas ?>
                </td>
            <?php } ?>
        </tr>
    </table>
</div>