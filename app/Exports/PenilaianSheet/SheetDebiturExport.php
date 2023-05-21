<?php

namespace App\Exports\PenilaianSheet;

use App\Models\Debitur;
use App\Models\KriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class SheetDebiturExport implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithMapping, WithEvents
{
    protected $id_periode;

    protected $row_count;

    public function __construct($id_periode)
    {
        $this->id_periode = $id_periode;
    }

    public function collection()
    {
        // Ambil data dari tabel debitur
        $debiturData = Debitur::select('id as id_debitur', 'nama', 'alamat')->where('status', 'aktif')->orderBy('updated_at', 'DESC')->get();

        // Inisialisasi data hasil penggabungan
        $mergedData = [];

        // Looping untuk setiap debitur
        foreach ($debiturData as $debitur) {
            // Ambil data kriteria penilaian untuk debitur ini
            $kriteriaData = KriteriaPenilaian::select('kriteria_penilaians.nama_kriteria', 'kriteria_penilaians.id as id_kriteria')
                ->where('kriteria_penilaians.id_periode', $this->id_periode)
                ->where('kriteria_penilaians.status', 'aktif')
                ->orderBy('kriteria_penilaians.bobot_kriteria', 'DESC')
                ->get();

            // Ubah data kriteria menjadi array asosiatif
            $kriteriaArray = [];
            foreach ($kriteriaData as $index => $kriteria) {
                $sub_kriteria = null;
                $kriteriaArray['kode-'.$kriteria->id_kriteria] = $kriteria->id_kriteria;
                $kriteriaArray['nama-'.$kriteria->id_kriteria] = $sub_kriteria;
            }

            // Gabungkan data kriteria dengan data debitur
            $mergedData[] = array_merge($debitur->toArray(), $kriteriaArray);
        }

        // Kembalikan data hasil penggabungan sebagai koleksi
        return collect($mergedData);
    }

    public function map($item): array
    {
        // Mapping data dinamis berdasarkan jumlah kriteria yang ada
        $data = [
            $this->id_periode,
            $item['id_debitur'],
            $item['nama'],
            $item['alamat'],
        ];

        $kriteriaData = KriteriaPenilaian::query()
            ->select('kriteria_penilaians.nama_kriteria', 'kriteria_penilaians.id as id_kriteria')
            ->where('kriteria_penilaians.id_periode', $this->id_periode)
            ->where('kriteria_penilaians.status', 'aktif')
            ->orderBy('kriteria_penilaians.bobot_kriteria', 'DESC')
            ->get();

        foreach ($kriteriaData as $kriteria) {
            array_push($data, $item['kode-'.$kriteria->id_kriteria]);
            array_push($data, $item['nama-'.$kriteria->id_kriteria]);
        }

        return $data;
    }

    public function title(): string
    {
        return 'Penilaian Debitur';
    }

    public function headings(): array
    {
        // Menggunakan judul kolom dari data kriteria
        $kriteriaData = KriteriaPenilaian::query()
            ->select('kriteria_penilaians.nama_kriteria')
            ->where('kriteria_penilaians.id_periode', $this->id_periode)
            ->where('kriteria_penilaians.status', 'aktif')
            ->orderBy('kriteria_penilaians.bobot_kriteria', 'DESC')
            ->get();

        $headings = ['Id Periode', 'Id Debitur', 'Nama Debitur', 'Alamat Debitur'];
        foreach ($kriteriaData as $kriteria) {
            array_push($headings, 'Kode '.$kriteria->nama_kriteria);
            array_push($headings, 'Nilai '.$kriteria->nama_kriteria.'*');
        }

        return $headings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $worksheet = $event->sheet;
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                $totalColumns = Coordinate::columnIndexFromString($highestColumn);

                // Looping untuk setiap kriteria
                $kriteriaData = KriteriaPenilaian::query()
                    ->select('kriteria_penilaians.nama_kriteria', 'kriteria_penilaians.id as id_kriteria')
                    ->where('kriteria_penilaians.id_periode', $this->id_periode)
                    ->where('kriteria_penilaians.status', 'aktif')
                    ->orderBy('kriteria_penilaians.bobot_kriteria', 'DESC')
                    ->get();

                $headingColumns = 6;

                foreach ($kriteriaData as $kriteria) {
                    $find_sub = SubKriteriaPenilaian::where('id_kriteria', $kriteria->id_kriteria)->orderBy('nilai_sub_kriteria', 'ASC')->get();

                    if ($find_sub->count() > 0) {
                        $sub_kriteria = $find_sub->pluck('nilai_sub_kriteria')->toArray();

                        // Menyusun data sub-kriteria penilaian menjadi format string yang sesuai dengan data validasi dropdown
                        $dropdownData = implode(',', $sub_kriteria);

                        $dropdownRange = 'Penilaian Debitur!'.Coordinate::stringFromColumnIndex($headingColumns).'2:'.Coordinate::stringFromColumnIndex($headingColumns).$highestRow;

                        // Set data validasi dengan dropdownData sebagai source
                        $validation = $worksheet->getCellByColumnAndRow($headingColumns, 2)->getDataValidation();
                        $validation->setType(DataValidation::TYPE_LIST)
                            ->setErrorStyle(DataValidation::STYLE_INFORMATION)
                            ->setAllowBlank(false)
                            ->setShowInputMessage(true)
                            ->setShowErrorMessage(true)
                            ->setShowDropDown(true)
                            ->setErrorTitle('Input error')
                            ->setError('Value is not in list.')
                            ->setPromptTitle('Pick from list')
                            ->setPrompt('Please pick a value from the drop-down list.')
                            ->setFormula1('"'.$dropdownData.'"')
                            ->setFormula2('"'.$dropdownData.'"');

                        // Set data validasi dropdown pada seluruh baris di kolom yang sama
                        for ($i = 3; $i <= $highestRow; $i++) {
                            $event->sheet->getCellByColumnAndRow($headingColumns, $i)->setDataValidation(clone $validation);
                        }
                    }

                    $headingColumns += 2; // Kolom untuk kode dan nilai kriteria, sehingga diincrement sebanyak 2
                }
            },
        ];
    }
}
