<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debitur extends Model
{
    use HasFactory, Uuid;

    protected $guarded = [];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_debitur', 'id');
    }

    public function rekomendasiDebitur()
    {
        return $this->hasMany(RekomendasiDebitur::class, 'id_debitur', 'id');
    }

    public function debiturTerpilih()
    {
        return $this->hasMany(RekomendasiDebitur::class, 'id_debitur', 'id');
    }
}
