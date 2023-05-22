<div class="page-break"></div>
<div class="header">
    <table width="100%" border-radius="0" cellspacing="0">
        <tr>
            <th colspan="16">PERMINTAAN PEMBAYARAN TPP BERDASARKAN PERHITUNGAN OBJEKTIF LAINNYA (UANG MAKAN)</th>
        </tr>
        <tr>
            <th colspan="16">DINAS PENDIDIKAN DAN KEBUDAYAAN</th>
        </tr>
        <tr>
            <th colspan="16">BULAN <?= strtoupper($baseModel->bulan($bulan)) ?> TAHUN <?= $tahun ?></th>
        </tr>
    </table>
</div>

<table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NAMA</th>
            <th rowspan="2">JABATAN</th>
            <th rowspan="2">NPWP</th>
            <th rowspan="2">NOMOR<br>REKENING</th>
            <th colspan="4" class="text-center">JUMLAH TPP</th>
            <th colspan="3" class="text-center">POTONGAN</th>
            <th rowspan="2" class="text-center">JUMLAH<br>SELURUH<br>POTONGAN</th>
            <th rowspan="2" class="text-center">JUMLAH TPP<br>YANG<br>DITERIMA</th>
            <th rowspan="2" class="text-center">POTONGAN<br>ZAKAT<br>BAZNAS</th>
            <th rowspan="2" class="text-center">JUMLAH TPP<br>YANG<br>DITERIMA</th>
        </tr>
        <tr>
            <td class="text-sm text-center">TPP</td>
            <td class="text-sm text-center">PPh<br>Pasal 21</td>
            <td class="text-sm text-center">BPJS<br>4%</td>
            <td class="text-sm text-center">JUMLAH</td>

            <td class="text-sm text-center">PPh<br>Pasal 21</td>
            <td class="text-sm text-center">BPJS<br>4%</td>
            <td class="text-sm text-center">BPJS<br>1%</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="16" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important; font-size: 14px !important;"><?= $laporan_title ?></th>
        </tr>
        <tr>
            <td colspan="16">&nbsp;</td>
        </tr>

        <?php
        $tpp_disiplin_totalArray = array();
        $pph21_totalArray = array();
        $bpjs4_totalArray = array();
        $jumlah_tpp_kotor_totalArray = array();
        $bpjs1_totalArray = array();
        $jumlah_potongan_totalArray = array();
        $jumlah_tpp_diterima_totalArray = array();
        $zakat_totalArray = array();
        $total_tpp_diterima_totalArray = array();

        $no = 1;
        foreach ($getJabatanArray as $jenis_ptk_id => $jabatan) { ?>
            <?php foreach ($getGolonganArray as $golongan) { ?>
                <?php
                $tpp_disiplinArray = array();
                $pph21Array = array();
                $bpjs4Array = array();
                $jumlah_tpp_kotorArray = array();
                $bpjs1Array = array();
                $jumlah_potonganArray = array();
                $jumlah_tpp_diterimaArray = array();
                $zakatArray = array();
                $total_tpp_diterimaArray = array(); ?>

                <?php if ($jenis_ptk_id == 1) { ?>
                    <tr>
                        <th colspan="16" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important;"><?= $golongan ? "GOLONGAN $golongan" : "GURU NON PNS" ?></th>
                    </tr>
                <?php } ?>

                <?php foreach ($model->getRekapTpp_array([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'jenis_ptk_id' => $jenis_ptk_id, // jabatan guru
                    'golongan' => $golongan,
                    'jenis_tpp_id' => $jenis_tpp_id
                ]) as $tpp) {
                    $tppPerbulan = $tpp->tpp_perbulan;
                    $kinerja = 0;
                    $disiplin = $tpp->persentase_kehadiran;
                    $tppKinerja = $tppPerbulan ? (($tppPerbulan * $kinerja) / 100) : 0;
                    $tppDisiplin = $tpp->jumlah_tpp_disiplin;

                    $tpp_disiplinArray[] = $tpp->jumlah_tpp_disiplin;
                    $pph21Array[] = $tpp->pph21;
                    $bpjs4Array[] = $tpp->bpjs4;
                    $jumlah_tpp_kotorArray[] = $tpp->jumlah_tpp_kotor;
                    $bpjs1Array[] = $tpp->bpjs1;
                    $jumlah_potonganArray[] = $tpp->jumlah_potongan;
                    $jumlah_tpp_diterimaArray[] = $tpp->jumlah_tpp_diterima;
                    $zakatArray[] = $tpp->zakat;
                    $total_tpp_diterimaArray[] = $tpp->total_tpp_diterima;


                    $tpp_disiplin_totalArray[] = $tpp->jumlah_tpp_disiplin;
                    $pph21_totalArray[] = $tpp->pph21;
                    $bpjs4_totalArray[] = $tpp->bpjs4;
                    $jumlah_tpp_kotor_totalArray[] = $tpp->jumlah_tpp_kotor;
                    $bpjs1_totalArray[] = $tpp->bpjs1;
                    $jumlah_potongan_totalArray[] = $tpp->jumlah_potongan;
                    $jumlah_tpp_diterima_totalArray[] = $tpp->jumlah_tpp_diterima;
                    $zakat_totalArray[] = $tpp->zakat;
                    $total_tpp_diterima_totalArray[] = $tpp->total_tpp_diterima;
                ?>

                    <tr>
                        <td><?= $no ?></td>
                        <td style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important;">
                            <?= $tpp->nama ?>
                            <small>
                                <?= $tpp->nip ? "<br>$tpp->nip" : null ?>
                                <?= $tpp->pangkat_golongan ? "<br>$tpp->pangkat_golongan" : null ?>
                            </small>
                        </td>
                        <td style="text-align: left !important;">
                            <?= $tpp->jenis_ptk_id >= 0 ? "$tpp->jenis_ptk " : null ?>
                        </td>
                        <td><?= $tpp->npwp ?></td>
                        <td><?= $tpp->nomor_rekening ?></td>

                        <td><?= $dataExcel ? $tpp->jumlah_tpp_disiplin : number_format($tpp->jumlah_tpp_disiplin, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->pph21 : number_format($tpp->pph21, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->bpjs4 : number_format($tpp->bpjs4, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->jumlah_tpp_kotor : number_format($tpp->jumlah_tpp_kotor, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->pph21 : number_format($tpp->pph21, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->bpjs4 : number_format($tpp->bpjs4, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->bpjs1 : number_format($tpp->bpjs1, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->jumlah_potongan : number_format($tpp->jumlah_potongan, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->jumlah_tpp_diterima : number_format($tpp->jumlah_tpp_diterima, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->zakat : number_format($tpp->zakat, 0, ',', '.'); ?></td>
                        <td><?= $dataExcel ? $tpp->total_tpp_diterima : number_format($tpp->total_tpp_diterima, 0, ',', '.'); ?></td>
                    </tr>
                <?php ++$no;
                } ?>

                <?php if ($jenis_ptk_id == 1) { ?>
                    <tr>
                        <th colspan="5" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important;">JUMLAH <?= $golongan ? "GOLONGAN $golongan" : "GURU NON PNS" ?></th>
                        <th><?= $dataExcel ? array_sum($tpp_disiplinArray) : number_format(array_sum($tpp_disiplinArray), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($pph21Array) : number_format(array_sum($pph21Array), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($bpjs4Array) : number_format(array_sum($bpjs4Array), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($jumlah_tpp_kotorArray) : number_format(array_sum($jumlah_tpp_kotorArray), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($pph21Array) : number_format(array_sum($pph21Array), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($bpjs4Array) : number_format(array_sum($bpjs4Array), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($bpjs1Array) : number_format(array_sum($bpjs1Array), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($jumlah_potonganArray) : number_format(array_sum($jumlah_potonganArray), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($jumlah_tpp_diterimaArray) : number_format(array_sum($jumlah_tpp_diterimaArray), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($zakatArray) : number_format(array_sum($zakatArray), 0, ',', '.') ?></th>
                        <th><?= $dataExcel ? array_sum($total_tpp_diterimaArray) : number_format(array_sum($total_tpp_diterimaArray), 0, ',', '.') ?></th>
                    </tr>
                <?php } ?>

                <?php if ($jenis_ptk_id == 1) { ?>
                    <tr>
                        <td colspan="16">&nbsp;</td>
                    </tr>
                <?php } ?>
            <?php } ?>

            <?php if ($jenis_ptk_id == 4) { ?>
                <!-- <tr>
                    <th colspan="5" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important;">JUMLAH</th>
                    <th><?= $dataExcel ? array_sum($tpp_disiplinArray) : number_format(array_sum($tpp_disiplinArray), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($pph21Array) : number_format(array_sum($pph21Array), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($bpjs4Array) : number_format(array_sum($bpjs4Array), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($jumlah_tpp_kotorArray) : number_format(array_sum($jumlah_tpp_kotorArray), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($pph21Array) : number_format(array_sum($pph21Array), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($bpjs4Array) : number_format(array_sum($bpjs4Array), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($bpjs1Array) : number_format(array_sum($bpjs1Array), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($jumlah_potonganArray) : number_format(array_sum($jumlah_potonganArray), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($jumlah_tpp_diterimaArray) : number_format(array_sum($jumlah_tpp_diterimaArray), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($zakatArray) : number_format(array_sum($zakatArray), 0, ',', '.') ?></th>
                    <th><?= $dataExcel ? array_sum($total_tpp_diterimaArray) : number_format(array_sum($total_tpp_diterimaArray), 0, ',', '.') ?></th>
                </tr> -->
            <?php } ?>

        <?php } ?>
        <tr>
            <td colspan="16">&nbsp;</td>
        </tr>
        <tr>
            <th colspan="5" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important;">JUMLAH TOTAL KESELURUHAN</th>
            <th><?= $dataExcel ? array_sum($tpp_disiplin_totalArray) : number_format(array_sum($tpp_disiplin_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($pph21_totalArray) : number_format(array_sum($pph21_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($bpjs4_totalArray) : number_format(array_sum($bpjs4_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($jumlah_tpp_kotor_totalArray) : number_format(array_sum($jumlah_tpp_kotor_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($pph21_totalArray) : number_format(array_sum($pph21_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($bpjs4_totalArray) : number_format(array_sum($bpjs4_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($bpjs1_totalArray) : number_format(array_sum($bpjs1_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($jumlah_potongan_totalArray) : number_format(array_sum($jumlah_potongan_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($jumlah_tpp_diterima_totalArray) : number_format(array_sum($jumlah_tpp_diterima_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($zakat_totalArray) : number_format(array_sum($zakat_totalArray), 0, ',', '.') ?></th>
            <th><?= $dataExcel ? array_sum($total_tpp_diterima_totalArray) : number_format(array_sum($total_tpp_diterima_totalArray), 0, ',', '.') ?></th>
        </tr>

    </tbody>
</table>


<br>
<div class="ttd">
    <table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
        <tr>
            <td colspan="10" style="width: 450px !important;"></td>
            <td style="text-align: left !important;">Kuala Tungkal, <?= $tanggal_cetak ? $baseModel->tgl_indo($tanggal_cetak) : $baseModel->tgl_indo(date('Y-m-d')) ?></td>
        </tr>
        <tr>
            <td colspan="16">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="10"></td>
            <?php if ($getSekolah) { ?>
                <td style="text-align: left !important;"><?= "KEPALA $getSekolah->nama,"; ?></td>
            <?php } else { ?>
                <td style="text-align: left !important;"><?= "KEPALA DINAS PENDIDIKAN DAN KEBUDAYAAN," ?></td>
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
            <td colspan="10"></td>
            <?php if ($getSekolah) { ?>
                <td style="vertical-align: bottom !important;">
                    <?= $kepsek ? $kepsek->nama : "_____________________" ?>
                </td>
            <?php } else { ?>
                <td style="vertical-align: bottom !important;">
                    <?= $nama_kepala_dinas ? $nama_kepala_dinas : "_____________________" ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="10"></td>
            <?php if ($getSekolah) { ?>
                <td>
                    NIP. <?= $kepsek ? $kepsek->nip : null ?>
                </td>
            <?php } else { ?>
                <td>
                    NIP. <?= $nip_kepala_dinas ?>
                </td>
            <?php } ?>
        </tr>
    </table>
</div>