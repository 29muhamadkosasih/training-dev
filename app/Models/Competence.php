<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;
    protected $connection = 'second_mysql'; // Nama koneksi dari config/database.php
    protected $table = 'competences'; // Nama tabel yang sesuai dengan database kedua
    protected $fillable = ['scheme_id', 'no_skkni', 'as'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }

    public function competenceCodes()
    {
        return $this->hasMany(CompetenceCode::class, 'competence_id');
    }
}
