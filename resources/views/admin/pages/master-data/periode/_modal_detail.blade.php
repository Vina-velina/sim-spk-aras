<div class="modal" id="modalDetailPeriode">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Detail Periode</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="" id="detailPeriode">
                <div class="modal-body row row-xs">
                    {{-- <div class="col-md-4 col-12">
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12 mg-t-5 text-center">
                                <img src="" alt="Foto Periode"
                                    style="object-fit: cover;height: 200px;width: 200px;" class="rounded-circle"
                                    id="fotoPeriode">
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-12">
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Nama Periode</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <input disabled class="form-control form-control-sm" name="nama_periode"
                                    placeholder="Masukkan Nama Periode" value="" type="text">
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Keterangan Periode</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <textarea disabled class="form-control form-control-sm" rows="5" name="keterangan"
                                    placeholder="Masukkan Keterangan Periode" type="text"></textarea>
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Tanggal Awal Penilaian</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <input disabled class="form-control form-control-sm" name="tgl_awal_penilaian"
                                    placeholder="Masukkan Tanggal Awal Penilaian Periode" value="" type="text">
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Tanggal Akhir Penilaian</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <input disabled class="form-control form-control-sm" name="tgl_akhir_penilaian"
                                    placeholder="Masukkan Tanggal Akhir Penilaian Periode" value=""
                                    type="text">
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Tanggal Pengumuman</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <input disabled class="form-control form-control-sm" name="tgl_pengumuman"
                                    placeholder="Masukkan Tanggal Pengumuman Periode" value="" type="text">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 col-12">
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Status</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <select disabled name="status" class="form-control form-control-sm" id="">
                                    <option value="aktif">Aktif
                                    </option>
                                    <option value="nonaktif">
                                        Non
                                        Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-sm btn-secondary" data-dismiss="modal" type="button">Tutup</button>
            </div>
        </div>
    </div>
</div>
