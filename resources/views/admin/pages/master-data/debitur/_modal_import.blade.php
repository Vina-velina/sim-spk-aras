<div class="modal" id="modalImportDebitur">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Import Debitur</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('admin.master-data.debitur.import') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-12">
                            <label class="form-label mg-b-0">File Excel</label>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control form-control-sm" name="file_excel" accept=".xlsx,.xls"
                                type="file">
                        </div>
                        <small class="mt-2">Format import excel dapat diunduh pada laman berikut ini (<a
                                href="{{ route('admin.master-data.debitur.download-template') }}">Format Import
                                Excel</a>)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn ripple btn-sm btn-primary">Import Data</button>
                    <button class="btn ripple btn-sm btn-secondary" data-dismiss="modal" type="button">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
