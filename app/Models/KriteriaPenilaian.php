<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    use HasFactory, Uuid;

    protected $guarded = [];

    public function subKriteriaPenilaian()
    {
        return $this->hasMany(SubKriteriaPenilaian::class, 'id_kriteria', 'id')->orderBy('nilai_sub_kriteria', 'asc');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id');
    }

    public function masterKriteriaPenilaian()
    {
        return $this->belongsTo(MasterKriteriaPenilaian::class, 'id_master_kriteria', 'id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_kriteria', 'id');
    }
}
