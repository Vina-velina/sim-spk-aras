<div class="modal" id="modalDetailDebitur">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Detail Debitur</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="" id="detailDebitur">
                <div class="modal-body row row-xs">
                    <div class="col-md-4 col-12">
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12 mg-t-5 text-center">
                                <img src="" alt="Foto Debitur"
                                    style="object-fit: cover;height: 200px;width: 200px;" class="rounded-circle"
                                    id="fotoDebitur">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Nama Debitur</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <input disabled class="form-control form-control-sm" name="nama_debitur"
                                    placeholder="Masukkan Nama Debitur" value="" type="text">
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Alamat Debitur</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <textarea disabled class="form-control form-control-sm" rows="5" name="alamat_debitur"
                                    placeholder="Masukkan Alamat Debitur" type="text"></textarea>
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Pekerjaan Debitur</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <input disabled class="form-control form-control-sm" name="pekerjaan_debitur"
                                    placeholder="Masukkan Pekerjaan Debitur" value="" type="text">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 col-12">
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Nomor Telepon/WhatsApp</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+62</span>
                                    </div>
                                    <input disabled class="form-control form-control-sm" value=""
                                        name="nomor_telepon" placeholder="8xxxxxxxxxx" type="number">
                                </div>
                            </div>

                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-12">
                                <label class="form-label mg-b-0">Nomor KTP</label>
                            </div>
                            <div class="col-md-12 mg-t-5">
                                <input disabled class="form-control form-control-sm" name="nomor_ktp"
                                    placeholder="xxxxxxxxxxxxxxxx" value="" type="number">
                            </div>
                        </div>
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
