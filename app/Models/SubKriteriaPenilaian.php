<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteriaPenilaian extends Model
{
    use HasFactory, Uuid;

    protected $guarded = [];

    public function kriteriaPenilaian()
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'id_kriteria', 'id');
    }
}
