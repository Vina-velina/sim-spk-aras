<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKriteriaPenilaian extends Model
{
    use HasFactory, Uuid;

    protected $guarded = [];

    public function kriteriaPenilaian()
    {
        return $this->hasMany(KriteriaPenilaian::class, 'id_master_kriteria', 'id');
    }
}
