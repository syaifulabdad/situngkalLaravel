@extends('layouts.adminlte.app')

@section('content')
    <style>
        .card-header,
        .card-body {
            padding: 6px !important;
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title form-inline">
                        <a href="javascript:void(0)" class="btn btn-default mr-2" onclick="reload()"><i class="fa fa-sync"></i></a>
                        <a href="javascript:void(0)" class="btn btn-primary mr-3 btnCreate"><i class="fa fa-plus"></i> Tambah</a>

                        @isset($dataTableFilter)
                            <div>
                                @foreach ($dataTableFilter as $key => $value)
                                    @php
                                        $key = isset(explode('.', $key)[1]) ? explode('.', $key)[1] : $key;
                                    @endphp
                                    <select id="{{ $key }}" class="form-control mr-2" onchange="reload()">
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: "100px",
                        className: "text-center nowrap"
                    },
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

        $('body').on('click', '.btnDelete', function() {
            var id = $(this).data('id');
            if (confirm("Yakin akan menghapus data ini.?")) {
                $.ajax({
                    type: 'DELETE',
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    url: "{{ $cUrl }}/" + id,
                    success: function(data) {
                        if (data.status) {
                            reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error.! Data gagal dihapus');
                    }
                });
                return false;
            }
        });
    </script>
    <div class="modal" id="modal-data" tabindex="-1">
        <div class="modal-dialog {{ isset($formSetting['modalSize']) ? $formSetting['modalSize'] : 'modal-md' }} #modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-data" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" class="form-control" name="id">
                        @foreach ($formData as $key => $value)
                            @isset($value['groupStart'])
                                <div class="card card-info">
                                    <div class="card-header">
                                        <span class="card-title">{{ $value['groupStart'] }}</span>
                                    </div>
                                    <div class="card-body">
                                    @endisset

                                    <div class="row mb-2">
                                        <label for="" class="col-sm-4 #col-form-label">{{ $value['label'] ?? ucwords(strtolower(str_replace(['_id', '_'], ['', ' '], $key))) }}</label>
                                        <div class="{{ isset($value['colWidth']) ? $value['colWidth'] : 'col-sm-8' }}">
                                            @if (isset($value['type']) && $value['type'] == 'select')
                                                @if (isset($value['options']) && is_array($value['options']))
                                                    @if (is_array($value['options']))
                                                        <select name="{{ $key }}{{ isset($value['multiple']) && $value['multiple'] ? '[]' : null }}" class="form-control form-control-sm {{ isset($value['class']) ? $value['class'] : null }} {{ isset($value['select2']) ? 'select2' : null }}" {{ isset($value['multiple']) && $value['multiple'] ? 'multiple' : null }}>
                                                            @foreach ($value['options'] as $optionKey => $optionValue)
                                                                <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        {{ $value['options'] }}
                                                    @endif
                                                @endif
                                            @elseif (isset($value['type']) && $value['type'] == 'textarea')
                                                <textarea name="{{ $key }}" class="form-control form-control-sm">{{ isset($value['value']) ? $value['value'] : null }}</textarea>
                                            @else
                                                <input type="{{ isset($value['type']) ? $value['type'] : 'text' }}" name="{{ $key }}" value="{{ isset($value['value']) ? $value['value'] : null }}" class="form-control form-control-sm">
                                            @endif
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    @isset($value['groupEnd'])
                                    </div>
                                </div>
                            @endisset
                        @endforeach
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btnSave"><i class="fa fa-save"></i>
                        Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.btnCreate').click(function() {
            save = 'add';
            $('[name="id"]').val(null);
            $('#form-data')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
            $('.select2').val(null).trigger('change');

            $('.modal-title').html('Tambah');
            $('#modal-data').modal('show');
        });

        $('body').on('click', '.btnEdit', function() {
            $('#form-data')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
            $('.select2').val(null).trigger('change');

            var id = $(this).data('id');
            $('[name="id"]').val(id);

            $.get("{{ $cUrl }}/" + id + "/edit", function(data) {
                $('[name="id"]').val(id);

                @foreach ($formData as $key => $value)
                    @if (isset($value['type']))
                        @if (!in_array($value['type'], ['file', 'password', 'select2']))
                            $('[name="{{ $key }}"]').val(data.{{ $key }});
                        @endif

                        @if (isset($value['select2']) && $value['select2'])
                            $('[name="{{ $key }}"]').val(data.{{ $key }}).trigger('change');
                        @endif
                    @else
                        $('[name="{{ $key }}"]').val(data.{{ $key }});
                    @endif
                @endforeach

                $('.modal-title').html('Edit');
                $('#modal-data').modal('show');
            });
        });

        $('.btnSave').click(function() {
            $('.btnSave').attr('disabled', true).html('<i class="fa fa-save"></i> menyimpan...');
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            var formData = $('#form-data').serialize();
            $.ajax({
                data: formData,
                url: "{{ $cUrl }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        $('#form-data').trigger("reset");
                        $('.modal').modal('hide');
                        reload();
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

        $('.select2').select2({
            theme: 'bootstrap4',
            width: "100%",
            dropdownParent: $('#modal-data'),
        })

        $('[name="desa_kelurahan_id"]').select2({
            theme: 'bootstrap4',
            width: "100%",
            dropdownParent: $('#modal-data'),
            minimumInputLength: 2,
            ajax: {
                url: '{{ route('ajaxKelurahan') }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })
    </script>
@endsection
