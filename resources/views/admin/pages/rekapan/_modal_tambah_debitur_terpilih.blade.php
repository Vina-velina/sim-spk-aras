<div class="modal" id="modalTambahDebiturTerpilih">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Debitur Terpilih</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('admin.rekapan-spk.detail.store-terpilih', $periode->id) }}"
                enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-12">
                            <label class="form-label mg-b-0">Debitur Terpilih Berdasarkan Rekomendasi <span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-12 mg-t-5">
                            <select name="debitur"
                                class="form-control form-control-sm @error('debitur') is-invalid @enderror"
                                id="">
                                <option value="" selected>-- Pilih Debitur Terpilih --</option>
                                @foreach ($rekomendasiByPeriode as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['text'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn ripple btn-sm btn-primary">Simpan</button>
                    <button class="btn ripple btn-sm btn-secondary" data-dismiss="modal" type="button">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
