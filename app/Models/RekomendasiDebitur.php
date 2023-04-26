<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiDebitur extends Model
{
    use HasFactory, Uuid;

    protected $guarded = [];

    public function debitur()
    {
        return $this->belongsTo(Debitur::class, 'id_debitur', 'id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
