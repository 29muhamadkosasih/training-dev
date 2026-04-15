<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenceCode extends Model
{
    use HasFactory;
    protected $connection = 'second_mysql'; // Nama koneksi dari config/database.php
    protected $table = 'competence_codes'; // Nama tabel yang sesuai dengan database kedua
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'competence_id');
    }
}
