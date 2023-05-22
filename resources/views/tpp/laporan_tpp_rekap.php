<div class="page-break"></div>
<div class="header">
    <table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
        <tr>
            <th colspan="14">REKAP DAFTAR PENERIMAAN TAMBAHAN PENGHASILAN PEGAWAI ( TPP )</th>
        </tr>
        <tr>
            <th colspan="14">PERTIMBANGAN OBJEKTIF LAINNYA ( UANG MAKAN )</th>
        </tr>
        <tr>
            <th colspan="14">DINAS PENDIDIKAN DAN KEBUDAYAAN</th>
        </tr>
        <tr>
            <th colspan="14">BULAN <?= strtoupper($baseModel->bulan($bulan)) ?> TAHUN <?= $tahun ?></th>
        </tr>
    </table>
</div>

<table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">JABATAN / GOLONGAN</th>
            <th rowspan="2" class="text-center">BULAN</th>
            <th rowspan="2" class="text-center">JUMLAH<br>PEGAWAI</th>
            <th colspan="4" class="text-center">JUMLAH TPP</th>
            <th colspan="3" class="text-center">POTONGAN</th>
            <th rowspan="2" class="text-center">JML <br>POTONGAN</th>
            <th rowspan="2" class="text-center">ZAKAT</th>
            <th rowspan="2" class="text-center">JUMLAH TPP<br>YANG DITERIMA</th>
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
        <?php
        $no = 1;
        foreach (['struktural', 'pelaksana', 'fungsional'] as $jabatanAsn) {
            if ($jabatanAsn == 'struktural') {
                $jabatanArray = [null];
            } elseif ($jabatanAsn == 'pelaksana') {
                $jabatanArray = [11, 30, 40, 42, 43, 44];
            } elseif ($jabatanAsn == 'fungsional') {
                $jabatanArray = [3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 20, 25, 26];
            }

        ?>
            <tr>
                <td><?= $no ?></td>
                <th colspan="13" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important;">
                    JABATAN <?= strtoupper($jabatanAsn) ?>
                    <?= $jabatanAsn == 'pelaksana' ? "(TATA USAHA)" : null ?>
                    <?= $jabatanAsn == 'fungsional' ? "(GURU, PENGAWAS SEKOLAH, CALON GURU PNS DAN CPNS)" : null ?>
                </th>
            </tr>
            <?php $no2 = 1;
            foreach ($getGolonganArray as $gol) {
                if (session('ops')) {
                    $jumlahRekapTpp = $model->jumlahRekapTpp([
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'jenis_tpp_id' => $jenis_tpp_id,
                        'golongan' => $gol,
                        'sekolah_id' => session('sekolah_id')
                    ], $jabatanArray);
                } else {
                    $jumlahRekapTpp = $model->jumlahRekapTpp([
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'jenis_tpp_id' => $jenis_tpp_id,
                        'golongan' => $gol
                    ], $jabatanArray);
                }


                $jumlah_pegawai = $jumlahRekapTpp['jumlah_pegawai'];
                $jumlah_tpp_disiplin = $jumlahRekapTpp['jumlah_tpp_disiplin'];
                $pph21 = $jumlahRekapTpp['pph21'];
                $bpjs4 = $jumlahRekapTpp['bpjs4'];
                $jumlah_tpp_kotor = $jumlahRekapTpp['jumlah_tpp_kotor'];
                $bpjs1 = $jumlahRekapTpp['bpjs1'];
                $jumlah_potongan = $jumlahRekapTpp['jumlah_potongan'];
                $total_tpp_diterima = $jumlahRekapTpp['total_tpp_diterima'];
                $zakat = $jumlahRekapTpp['zakat'];

            ?>
                <tr>
                    <td></td>
                    <td style="text-align: left !important;"><?= $gol ? "- GOLONGAN $gol" : "GURU NON PNS" ?></td>
                    <?php if ($no2 == 1) { ?>
                        <td rowspan="<?= count($getGolonganArray) ?>"><?= strtoupper($baseModel->bulan($bulan)) ?></td>
                    <?php } ?>
                    <td><?= $jumlah_pegawai ?></td>
                    <td><?= $dataExcel ? $jumlah_tpp_disiplin : number_format($jumlah_tpp_disiplin, 0, 0, '.') ?></td>
                    <td><?= $dataExcel ? $pph21 : number_format($pph21, 0, 0, '.') ?></td>
                    <td><?= $dataExcel ? $bpjs4 : number_format($bpjs4, 0, 0, '.') ?></td>
                    <td><?= $dataExcel ? $jumlah_tpp_kotor : number_format($jumlah_tpp_kotor, 0, 0, '.') ?></td>
                    <td><?= $dataExcel ? $pph21 : number_format($pph21, 0, 0, '.') ?></td>
                    <td><?= $dataExcel ? $bpjs4 : number_format($bpjs4, 0, 0, '.') ?></td>
                    <td><?= $dataExcel ? $bpjs1 : number_format($bpjs1, 0, 0, '.') ?></td>
                    <td><?= $dataExcel ? $jumlah_potongan : number_format($jumlah_potongan, 0, 0, '.') ?></td>
                    <td><?= $dataExcel ? $zakat : number_format($zakat, 0, 0, '.') ?></td>
                    <td><?= $dataExcel ? $total_tpp_diterima : number_format($total_tpp_diterima, 0, 0, '.') ?></td>
                </tr>
            <?php ++$no2;
            } ?>

            <?php
            $jumlahRekapTpp = $model->jumlahRekapTpp([
                'tahun' => $tahun,
                'bulan' => $bulan,
                'jenis_tpp_id' => $jenis_tpp_id,
            ], $jabatanArray);

            $jumlah_pegawai = $jumlahRekapTpp['jumlah_pegawai'];
            $jumlah_tpp_disiplin = $jumlahRekapTpp['jumlah_tpp_disiplin'];
            $pph21 = $jumlahRekapTpp['pph21'];
            $bpjs4 = $jumlahRekapTpp['bpjs4'];
            $jumlah_tpp_kotor = $jumlahRekapTpp['jumlah_tpp_kotor'];
            $bpjs1 = $jumlahRekapTpp['bpjs1'];
            $jumlah_potongan = $jumlahRekapTpp['jumlah_potongan'];
            $total_tpp_diterima = $jumlahRekapTpp['total_tpp_diterima'];
            $zakat = $jumlahRekapTpp['zakat'];
            ?>

            <tr>
                <th colspan="3" style="text-align: center !important; padding-top: 6px !important; padding-bottom: 6px !important; font-size: 12px !important;">JUMLAH</th>
                <th><?= $jumlah_pegawai ?></th>
                <th><?= $dataExcel ? $jumlah_tpp_disiplin : number_format($jumlah_tpp_disiplin, 0, 0, '.') ?></th>
                <th><?= $dataExcel ? $pph21 : number_format($pph21, 0, 0, '.') ?></th>
                <th><?= $dataExcel ? $bpjs4 : number_format($bpjs4, 0, 0, '.') ?></th>
                <th><?= $dataExcel ? $jumlah_tpp_kotor : number_format($jumlah_tpp_kotor, 0, 0, '.') ?></th>
                <th><?= $dataExcel ? $pph21 : number_format($pph21, 0, 0, '.') ?></th>
                <th><?= $dataExcel ? $bpjs4 : number_format($bpjs4, 0, 0, '.') ?></th>
                <th><?= $dataExcel ? $bpjs1 : number_format($bpjs1, 0, 0, '.') ?></th>
                <th><?= $dataExcel ? $jumlah_potongan : number_format($jumlah_potongan, 0, 0, '.') ?></th>
                <th><?= $dataExcel ? $zakat : number_format($zakat, 0, 0, '.') ?></th>
                <th><?= $dataExcel ? $total_tpp_diterima : number_format($total_tpp_diterima, 0, 0, '.') ?></th>
            </tr>
        <?php ++$no;
        } ?>
        <?php
        $jumlahRekapTpp = $model->jumlahRekapTpp([
            'tahun' => $tahun,
            'bulan' => $bulan,
            'jenis_tpp_id' => $jenis_tpp_id,
        ], range(1, 20));

        $jumlah_pegawai = $jumlahRekapTpp['jumlah_pegawai'];
        $jumlah_tpp_disiplin = $jumlahRekapTpp['jumlah_tpp_disiplin'];
        $pph21 = $jumlahRekapTpp['pph21'];
        $bpjs4 = $jumlahRekapTpp['bpjs4'];
        $jumlah_tpp_kotor = $jumlahRekapTpp['jumlah_tpp_kotor'];
        $bpjs1 = $jumlahRekapTpp['bpjs1'];
        $jumlah_potongan = $jumlahRekapTpp['jumlah_potongan'];
        $total_tpp_diterima = $jumlahRekapTpp['total_tpp_diterima'];
        $zakat = $jumlahRekapTpp['zakat'];
        ?>

        <tr>
            <th colspan="14">&nbsp;</th>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left !important; padding-top: 6px !important; padding-bottom: 6px !important; font-size: 14px !important;">JUMLAH TOTAL KESELURUHAN</th>
            <th><?= $jumlah_pegawai ?></th>
            <th><?= $dataExcel ? $jumlah_tpp_disiplin : number_format($jumlah_tpp_disiplin, 0, 0, '.') ?></th>
            <th><?= $dataExcel ? $pph21 : number_format($pph21, 0, 0, '.') ?></th>
            <th><?= $dataExcel ? $bpjs4 : number_format($bpjs4, 0, 0, '.') ?></th>
            <th><?= $dataExcel ? $jumlah_tpp_kotor : number_format($jumlah_tpp_kotor, 0, 0, '.') ?></th>
            <th><?= $dataExcel ? $pph21 : number_format($pph21, 0, 0, '.') ?></th>
            <th><?= $dataExcel ? $bpjs4 : number_format($bpjs4, 0, 0, '.') ?></th>
            <th><?= $dataExcel ? $bpjs1 : number_format($bpjs1, 0, 0, '.') ?></th>
            <th><?= $dataExcel ? $jumlah_potongan : number_format($jumlah_potongan, 0, 0, '.') ?></th>
            <th><?= $dataExcel ? $zakat : number_format($zakat, 0, 0, '.') ?></th>
            <th><?= $dataExcel ? $total_tpp_diterima : number_format($total_tpp_diterima, 0, 0, '.') ?></th>
        </tr>

    </tbody>
</table>


<br>
<div class="ttd">
    <table width="100%" class="table-bordered" border-radius="0" cellspacing="0">
        <tr>
            <td colspan="2" style="width: 70px !important;">&nbsp;</td>
            <td colspan="8" style="text-align: left !important;">Mengetahui,</td>
            <!-- <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td> -->
            <td colspan="4" style="text-align: left !important;">Kuala Tungkal, <?= $tanggal_cetak ? $baseModel->tgl_indo($tanggal_cetak) : $baseModel->tgl_indo(date('Y-m-d')) ?></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="8" style="text-align: left !important;">Pengguna Anggaran</td>
            <!-- <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td> -->
            <td colspan="4" style="text-align: left !important;">Bendahara Pengeluaran</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <?php if ($getSekolah) { ?>
                <td colspan="8" style="text-align: left !important;"><?= "KEPALA $getSekolah->nama"; ?></td>
            <?php } else { ?>
                <td colspan="8" style="text-align: left !important;"><?= "KEPALA DINAS PENDIDIKAN DAN KEBUDAYAAN" ?></td>
            <?php } ?>
            <!-- <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td> -->
            <?php if ($getSekolah) { ?>
                <td colspan="4" style="text-align: left !important;"><?= "$getSekolah->nama,"; ?></td>
            <?php } else { ?>
                <td colspan="4" style="text-align: left !important;"><?= "$nama_instansi," ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="14">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="14">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="14">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <?php if ($getSekolah) { ?>
                <td colspan="8" style="vertical-align: bottom !important; text-align: left !important;">
                    <?= $kepsek ? $kepsek->nama : "_____________________" ?>
                </td>
            <?php } else { ?>
                <td colspan="8" style="vertical-align: bottom !important; text-align: left !important;">
                    <?= $nama_kepala_dinas ? $nama_kepala_dinas : "_____________________" ?>
                </td>
            <?php } ?>
            <!-- <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td> -->
            <td colspan="4" style="vertical-align: bottom !important;">_____________________</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <?php if ($getSekolah) { ?>
                <td colspan="8" style="text-align: left !important;">
                    NIP. <?= $kepsek ? $kepsek->nip : null ?>
                </td>
            <?php } else { ?>
                <td colspan="8" style="text-align: left !important;">
                    NIP. <?= $nip_kepala_dinas ?>
                </td>
            <?php } ?>
            <!-- <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td> -->
            <td colspan="4" style="text-align: left !important;">NIP.</td>
        </tr>
    </table>
</div>