@extends('layouts.adminlte.app')

@section('content')
    <style>
        .card-header,
        .card-body {
            padding: 6px !important;
        }

        th,
        td {
            vertical-align: middle !important
        }
    </style>
    <form action="javascript:void(0)" id="form-data" method="POST" class="row">
        @csrf
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title form-inline">
                        <a href="javascript:void(0)" class="btn btn-default mr-2" onclick="reload()"><i class="fa fa-sync"></i></a>
                        <input id="bulan" type="month" class="form-control mr-3" value="{{ date('Y-m') }}" onchange="reload()">

                        @isset($dataTableFilter)
                            <div>
                                @foreach ($dataTableFilter as $key => $value)
                                    @php
                                        $key = isset(explode('.', $key)[1]) ? explode('.', $key)[1] : $key;
                                        $hidden = false;
                                        if (in_array($key, ['kecamatan_id', 'sekolah_id']) && session('sekolah_id')) {
                                            $hidden = 'd-none';
                                        }
                                    @endphp
                                    <select id="{{ $key }}" class="form-control mr-1 {{ $hidden }}" onchange="reload()">
                                        @if (is_array($value))
                                            <option value="">{{ ucwords(strtolower(str_replace(['_id', '_'], ['', ' '], $key))) }}</option>
                                            @foreach ($value as $optionKey => $optionValue)
                                                <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                                            @endforeach
                                        @else
                                            {{ $value }}
                                        @endif
                                    </select>
                                @endforeach
                            </div>
                        @endisset
                    </div>
                </div>
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title form-inline">
                        <a href="javascript:void(0)" class="btn btn-warning #btn-sm mr-1 proses" onclick="getLaporan('sptjm')" data-dataPrint="sptjm" data-submit="modal"><i class="fa fa-file-pdf"></i> SPTJM</a>
                        <a href="javascript:void(0)" class="btn btn-danger #btn-sm mr-1 proses" onclick="getLaporan('pdf')" data-dataPrint="pdf" data-submit="modal"><i class="fa fa-file-pdf"></i> LAPORAN PDF</a>
                        <a href="javascript:void(0)" class="btn btn-success #btn-sm mr-1 proses" onclick="getLaporan('excel')" data-dataPrint="excel" data-submit="modal"><i class="fa fa-file-excel"></i> LAPORAN EXCEL</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="#table-responsive">
                        <table id="dataTables" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @foreach ($dataTable as $key => $value)
                                        <th>
                                            @if (isset($value['label']) && $value['label'])
                                                {!! $value['label'] !!}
                                            @else
                                                {{ ucwords(strtolower(str_replace(['_id', '_'], ['', ' '], isset(explode('.', $key)[1]) ? explode('.', $key)[1] : $key))) }}
                                            @endif
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script>
        var table;
        var ordering = {{ isset($dataTableOrder) ? 'true' : 'false' }};

        $(function() {
            table = $('#dataTables').DataTable({
                initComplete: function() {
                    var api = this.api();
                    $('#dataTables_filter input')
                        .off('.DT')
                        .on('keyup.DT', function(e) {
                            if (e.keyCode == 13) {
                                api.search(this.value).draw();
                            }
                        });
                },
                "language": {
                    "paginate": {
                        "previous": "<",
                        "next": ">",
                    },
                    "emptyTable": "<div class='m-4 text-bold'>Tidak ada data yang ditampilkan.</div>"
                },
                oLanguage: {
                    sProcessing: 'loading...',
                    sSearch: '',
                    sSearchPlaceholder: 'Search',
                    sLengthMenu: '_MENU_',
                },
                "paging": true,
                "searching": true,
                "ordering": ordering,
                "info": true,
                "autoWidth": false,
                "lengthChange": true,
                "bDestroy": true,
                "responsive": true,
                'processing': true,
                'serverSide': true,
                "ajax": {
                    "url": "{{ $cUrl }}",
                    "type": "GET",
                    data: function(dt) {
                        dt._token = "{{ csrf_token() }}";
                        dt.bulan = $('#bulan').val();
                        @isset($dataTableFilter)
                            @foreach ($dataTableFilter as $key => $value)
                                dt.{{ isset(explode('.', $key)[1]) ? explode('.', $key)[1] : $key }} = $('#{{ isset(explode('.', $key)[1]) ? explode('.', $key)[1] : $key }}').val();
                            @endforeach
                        @endisset
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "30px",
                        className: "text-center nowrap"
                    },

                    @foreach ($dataTable as $key => $value)
                        {
                            data: "{{ isset(explode('.', $key)[1]) ? explode('.', $key)[1] : $key }}",
                            name: "{{ $key }}",
                            orderable: {{ isset($value['orderable']) && $value['orderable'] ? 'true' : 'false' }},
                            searchable: {{ isset($value['searchable']) && $value['searchable'] ? 'true' : 'false' }},
                            width: "{{ isset($value['width']) && $value['width'] ? $value['width'] : null }}",
                            className: "{{ isset($value['className']) && $value['className'] ? $value['className'] : null }}",
                        },
                    @endforeach
                ],
                @isset($dataTableOrder)
                    order: [
                        <?php foreach ($dataTableOrder as $orderName) {
                            $no = 1;
                            foreach ($dataTable as $key => $value) {
                                $order = explode(' ', $orderName);
                                if ($key == $order[0]) {
                                    echo "[$no,'$order[1]'],";
                                }
                                ++$no;
                            }
                        } ?>
                    ]
                @endisset

            });
        });

        function reload() {
            table.ajax.reload(null, false);
        }

        $('#kecamatan_id').change(function() {
            $.get('{{ route('ajaxSekolah') }}', {
                'kecamatan_id': $(this).val(),
            }, function(data) {
                $('#sekolah_id').html(data)
            })
        })
    </script>



    <div class="modal" id="modal-print">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="form-print" class="form-horizontal">
                        <div class="form-group row mb-2">
                            <label class="col-md-12">Tanggal Cetak</label>
                            <div class="col-md-12">
                                <input type="date" name="tanggal-cetak" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>">
                                <span class="error invalid-feedback">Invalid</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-md-12">Ukuran Kertas</label>
                            <div class="col-md-12">
                                <select name="paper-size" class="form-control form-control-sm">
                                    <option value="A4">A4</option>
                                    <option value="F4">F4</option>
                                    <option value="legal">Legal</option>
                                </select>
                                <span class="error invalid-feedback">Invalid</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2 d-none">
                            <label class="col-md-12">Margin</label>
                            <div class="col-md-6">
                                <input type="number" name="margin-left" class="form-control form-control-sm" value="" placeholder="Left">
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="margin-bottom" class="form-control form-control-sm" value="35" placeholder="Bottom">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="downloadLaporan()" data-submit="download"><i class="fa fa-download"></i> SUBMIT</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var dataPrint;

        function getLaporan(data) {
            dataPrint = data;
            $('.modal-title').html('Download Laporan');
            $('#modal-print').modal('show');
        }

        function downloadLaporan() {
            var bulan = $('#bulan').val();
            var jenis_tpp_id = $('#jenis_tpp_id').val();
            var kecamatan_id = $('#kecamatan_id').val();
            var sekolah_id = $('#sekolah_id').val();

            var paper_size = $('[name="paper-size"]').val();
            var tanggal_cetak = $('[name="tanggal-cetak"]').val();
            var margin_left = $('[name="margin-left"]').val();
            var margin_bottom = $('[name="margin-bottom"]').val();

            if (dataPrint == 'sptjm') {
                if (sekolah_id) {
                    window.open('{{ route('laporan-tpp-pdf') }}?bulan=' + bulan + '&jenis_tpp_id=' + jenis_tpp_id + '&sekolah_id=' + sekolah_id + '&sptjm=1' + '&paper-size=' + paper_size + '&tanggal-cetak=' + tanggal_cetak + '&margin-left=' + margin_left + '&margin-bottom=' + margin_bottom);
                } else {
                    alert('Pilih Sekolah')
                }
            } else if (dataPrint == 'pdf') {
                if (jenis_tpp_id) {
                    window.open('{{ route('laporan-tpp-pdf') }}?bulan=' + bulan + '&jenis_tpp_id=' + jenis_tpp_id + '&sekolah_id=' + sekolah_id + '&paper-size=' + paper_size + '&tanggal-cetak=' + tanggal_cetak + '&margin-left=' + margin_left + '&margin-bottom=' + margin_bottom);
                } else {
                    alert('Pilih Jenis TPP')
                }
            } else if (dataPrint == 'excel') {
                if (jenis_tpp_id) {
                    window.open('{{ route('laporan-tpp-pdf') }}?bulan=' + bulan + '&jenis_tpp_id=' + jenis_tpp_id + '&sekolah_id=' + sekolah_id + '&paper-size=' + paper_size + '&tanggal-cetak=' + tanggal_cetak + '&margin-left=' + margin_left + '&margin-bottom=' + margin_bottom);
                } else {
                    alert('Pilih Jenis TPP')
                }
            }
        }
    </script>
@endsection
