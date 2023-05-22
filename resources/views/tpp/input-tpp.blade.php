@extends('layouts.adminlte.app')

@section('content')
    <style>
        .card-header,
        .card-body {
            padding: 6px !important;
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
                <div class="card-body">
                    <div class="#table-responsive">
                        <table id="dataTables" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @foreach ($dataTable as $key => $value)
                                        <th>
                                            {{ $value['label'] ?? ucwords(strtolower(str_replace(['_id', '_'], ['', ' '], isset(explode('.', $key)[1]) ? explode('.', $key)[1] : $key))) }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="javascript:void(0)" class="btn btn-success float-right btnSave"><i class="fa fa-save"></i> SIMPAN</a>
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

        $('.btnSave').click(function() {
            $('.btnSave').attr('disabled', true).html('menyimpan...');
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            var formData = $('#form-data').serialize();
            $.ajax({
                data: formData,
                url: "{{ route('input-tpp.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        $('#form-data').trigger("reset");
                        table.draw();
                        alert('Data berhasil disimpan');
                    } else {
                        for (var i = 0; i < data.error_string.length; i++) {
                            if (data.error_string[i]) {
                                $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid').next(
                                    '.invalid-feedback').html(
                                    data.error_string[i]);
                            }
                        }
                    }
                    $('.btnSave').attr('disabled', false).html('<i class="fa fa-save"></i> Simpan');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                    $('.btnSave').attr('disabled', false).html('<i class="fa fa-save"></i> Simpan');

                }
            });
        });

        $('#kecamatan_id').change(function() {
            $.get('{{ route('ajaxSekolah') }}', {
                'kecamatan_id': $(this).val(),
            }, function(data) {
                $('#sekolah_id').html(data)
            })
        })
    </script>
@endsection
