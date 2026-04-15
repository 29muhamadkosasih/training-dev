<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenceKuk extends Model
{
    use HasFactory;
    protected $connection = 'second_mysql'; // Nama koneksi dari config/database.php
    protected $table = 'competence_code_element_kuks'; // Nama tabel yang sesuai dengan database kedua
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;


    public function competenceCodeElement()
    {
        return $this->belongsTo(CompetenceCodeElement::class, 'competence_code_element_id');
    }
}
