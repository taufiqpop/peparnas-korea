@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal'];
@endphp

@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="text-sm-right">
                                <a href="{{ route('participants.generate') }}"
                                    class="btn btn-success btn-rounded waves-effect waves-light btn-generate"><i
                                        class="bx bx-loader mr-1"></i> Generate Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table class="table table-striped" id="table-data" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis</th>
                                    <th>Berkas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal KK --}}
    <div class="modal fade" id="fileModalKK" tabindex="-1" aria-labelledby="fileModalKKLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalKKLabel">File KK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="fileViewerKK" src="" style="width: 100%; height: 500px; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal KTP --}}
    <div class="modal fade" id="fileModalKTP" tabindex="-1" aria-labelledby="fileModalKTPLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalKTPLabel">File KTP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="fileViewerKTP" src="" style="width: 100%; height: 500px; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal PP --}}
    <div class="modal fade" id="fileModalPP" tabindex="-1" aria-labelledby="fileModalPPLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalPPLabel">File PP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="fileViewerPP" src="" style="width: 100%; height: 500px; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        $(() => {
            // List
            table = $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                language: dtLang,
                ajax: {
                    url: BASE_URL + 'participants/data',
                    type: 'get',
                    dataType: 'json'
                },
                order: [
                    [2, 'asc'],
                    [1, 'asc']
                ],
                columnDefs: [{
                    targets: [0],
                    searchable: false,
                    orderable: false,
                    className: 'text-center align-top',
                }, {
                    targets: [1, 2],
                    className: 'text-left align-top'
                }, {
                    targets: [-1],
                    visible: false,
                }],
                columns: [{
                    data: 'DT_RowIndex'
                }, {
                    data: 'eng_given_nm',
                }, {
                    data: 'category_sys_cd',
                    render: function(data, type, row) {
                        if (data == 'C00009') {
                            return `<span class="badge badge-danger">Atlet<span>`;
                        } else if (data == 'C00012') {
                            return `<span class="badge badge-info">Pelatih<span>`;
                        } else {
                            return '';
                        }
                    }
                }, {
                    data: 'partic_id',
                    render: function(data, type, row) {
                        console.log(row);
                        let fileKK = BASE_URL + `storage${row.kk.save_file_nm}`;
                        let fileKTP = BASE_URL + `storage${row.ktp.save_file_nm}`;
                        let filePP = BASE_URL + `storage${row.pp.save_file_nm}`;

                        return `
                                <button class="btn btn-primary btn-view-kk" data-url="${fileKK}" data-toggle="modal" data-target="#fileModalKK">
                                    KK 
                                </button>

                                <button class="btn btn-primary btn-view-ktp" data-url="${fileKTP}" data-toggle="modal" data-target="#fileModalKTP">
                                    KTP
                                </button>

                                <button class="btn btn-primary btn-view-pp" data-url="${filePP}" data-toggle="modal" data-target="#fileModalPP">
                                    PP 
                                </button>
                            `;
                        return '-';
                    }
                }, {
                    data: 'bpjs_file_id',
                }]
            })

            $(document).on('click', '.btn-view-kk', function() {
                let fileKK = $(this).data('url');
                $('#fileViewerKK').attr('src', fileKK);
            });

            $(document).on('click', '.btn-view-ktp', function() {
                let fileKTP = $(this).data('url');
                $('#fileViewerKTP').attr('src', fileKTP);
            });

            $(document).on('click', '.btn-view-pp', function() {
                let filePP = $(this).data('url');
                $('#fileViewerPP').attr('src', filePP);
            });
        })
    </script>
@endpush
