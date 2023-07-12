<div class="modal" id="modalPerhitunganAras">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Perhitungan ARAS</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" style="max-height: 600px;overflow-x: scroll;">
                <div class="row row-xs align-items-center mg-b-20">
                    <div class="table-responsive">
                        <h6>1. Nilai Alternatif Kriteria</h6>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="bg-info text-white">
                                <tr align="center">
                                    <th>Alternatif</th>
                                    @foreach ($dssData['kriteria'] as $kriteria)
                                        <th>{{ $kriteria->nama_kriteria }} - Bobot {{ $kriteria->bobot_kriteria }}%</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dssData['alternatif'] as $alternatif)
                                    <tr align="center">
                                        <td>{{ $alternatif->nama }}</td>
                                        @foreach ($dssData['kriteria'] as $kriteria)
                                            <td>
                                                {{ $dssData['pembentukan_matriks_x'][$kriteria->id][$alternatif->id] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive mt-2">
                        <h6>2. Pembentukan Matriks Keputusan (X)</h6>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="bg-info text-white">
                                <tr align="center">
                                    <th>Alternatif</th>
                                    @foreach ($dssData['kriteria'] as $index => $kriteria)
                                        <th>{{ 'K' . $index + 1 }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <td>A<sub>0</sub></td>
                                    @foreach ($dssData['kriteria'] as $kriteria)
                                        <td>
                                            {{ $dssData['pembentukan_matriks_x0'][$kriteria->id] }}
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($dssData['alternatif'] as $index => $alternatif)
                                    <tr align="center">
                                        <td>{{ 'A' . $index + 1 }}</td>
                                        @foreach ($dssData['kriteria'] as $kriteria)
                                            <td>
                                                {{ $dssData['pembentukan_matriks_x'][$kriteria->id][$alternatif->id] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive mt-2">
                        <h6>3. Merumuskan Matriks Keputusan (X)</h6>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="bg-info text-white">
                                <tr align="center">
                                    <th>Alternatif</th>
                                    @foreach ($dssData['kriteria'] as $index => $kriteria)
                                        <th>{{ 'K' . $index + 1 }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <td>A<sub>0</sub></td>
                                    @foreach ($dssData['kriteria'] as $kriteria)
                                        <td>
                                            {{ $dssData['merumuskan_matriks_x0'][$kriteria->id] }}
                                        </td>
                                    @endforeach
                                </tr>

                                @foreach ($dssData['alternatif'] as $index => $alternatif)
                                    <tr align="center">
                                        <td>{{ 'A' . $index + 1 }}</td>
                                        @foreach ($dssData['kriteria'] as $kriteria)
                                            <td>
                                                {{ $dssData['merumuskan_matriks_x'][$kriteria->id][$alternatif->id] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr align="center" class="bg-light">
                                    <th>TOTAL</th>
                                    @foreach ($dssData['kriteria'] as $kriteria)
                                        <th>
                                            {{ $dssData['total_nilai_matriks'][$kriteria->id] }}
                                        </th>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive mt-2">
                        <h6>4. Matriks Normalisasi</h6>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="bg-info text-white">
                                <tr align="center">
                                    <th>Alternatif</th>
                                    @foreach ($dssData['kriteria'] as $index => $kriteria)
                                        <th>{{ 'K' . $index + 1 }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <td>A<sub>0</sub></td>
                                    @foreach ($dssData['kriteria'] as $index => $kriteria)
                                        <td>
                                            {{ $dssData['normalisasi_matriks_x0'][$kriteria->id] }}
                                        </td>
                                    @endforeach
                                </tr>

                                @foreach ($dssData['alternatif'] as $index => $alternatif)
                                    <tr align="center">
                                        <td>{{ 'A' . $index + 1 }}</td>
                                        @foreach ($dssData['kriteria'] as $kriteria)
                                            <td> {{ $dssData['normalisasi_matriks_x'][$kriteria->id][$alternatif->id] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive mt-2">
                        <h6>5. Bobot Yang Digunakan</h6>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="bg-info text-white">
                                <tr align="center">
                                    @foreach ($dssData['kriteria'] as $index => $kriteria)
                                        <th>{{ 'K' . $index + 1 . ' (' . ucWords($kriteria->jenis) . ')' }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    @foreach ($dssData['kriteria'] as $kriteria)
                                        <td>
                                            {{ $kriteria->bobot_kriteria / 100 }}
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive mt-2">
                        <h6>6. Matriks Normalisasi Terbobot</h6>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="bg-info text-white">
                                <tr align="center">
                                    <th>Alternatif</th>
                                    @foreach ($dssData['kriteria'] as $index => $kriteria)
                                        <th>{{ 'K' . $index + 1 }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <td>A<sub>0</sub></td>
                                    @foreach ($dssData['kriteria'] as $index => $kriteria)
                                        <td>
                                            {{ $dssData['perhitungan_nilai_akhir'][$kriteria->id] }}
                                        </td>
                                    @endforeach
                                </tr>

                                @foreach ($dssData['alternatif'] as $index => $alternatif)
                                    <tr align="center">
                                        <td>{{ 'A' . $index + 1 }}</td>
                                        @foreach ($dssData['kriteria'] as $kriteria)
                                            <td>
                                                {{ $dssData['normalisasi_terbobot'][$kriteria->id][$alternatif->id] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive mt-2">
                        <h6>7. Perhitungan Nilai Akhir</h6>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="bg-info text-white">
                                <tr align="center">
                                    <th>Alternatif</th>
                                    <th width="30%">Nilai S</th>
                                    <th width="30%">Nilai K</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <td>A<sub>0</sub></td>
                                    <td>{{ $dssData['total_perhitungan_nilai_akhir'] }}</td>
                                    <td>{{ $dssData['hasil_akhir_x0'] }} </td>
                                </tr>

                                @foreach ($dssData['alternatif'] as $index => $alternatif)
                                    <tr align="center">
                                        <td>{{ 'A' . $index + 1 . ' (' . $alternatif->nama . ')' }}</td>
                                        <td>{{ $dssData['total_normalisasi_terbobot'][$alternatif->id] }}</td>
                                        <td>{{ $dssData['hasil_akhir_x'][$alternatif->id] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-sm btn-secondary" data-dismiss="modal" type="button">Tutup</button>
            </div>
        </div>
    </div>
</div>
