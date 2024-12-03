@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal'];
@endphp

@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table class="table table-striped" id="table-data" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Filename</th>
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

    {{-- Modal Berkas --}}
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">File Viewer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="fileViewer" src="" style="width: 100%; height: 500px; border: none;"></iframe>
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
                    [3, 'desc']
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
                    data: 'file_nm',
                }, {
                    data: 'save_file_nm',
                    render: function(data, type, row) {
                        if (data) {
                            let fileUrl = BASE_URL + `storage${data}`;
                            return `
                                <button class="btn btn-primary btn-view-file" data-url="${fileUrl}" data-toggle="modal" data-target="#fileModal">
                                    View File 
                                </button>
                                <br><br>
                                ${fileUrl}
                            `;
                        }
                        return '-';
                    }
                }, {
                    data: 'file_id',
                }]
            })

            $(document).on('click', '.btn-view-file', function() {
                let fileUrl = $(this).data('url');
                $('#fileViewer').attr('src', fileUrl);
            });
        })
    </script>
@endpush
