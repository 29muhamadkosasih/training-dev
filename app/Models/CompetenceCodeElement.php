<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenceCodeElement extends Model
{
    use HasFactory;
    protected $connection = 'second_mysql'; // Nama koneksi dari config/database.php
    protected $table = 'competence_code_elements'; // Nama tabel yang sesuai dengan database kedua
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    public function competenceCode()
    {
        return $this->belongsTo(CompetenceCode::class, 'competence_code_id');
    }
}
