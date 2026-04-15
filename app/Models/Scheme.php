<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    use HasFactory;
    protected $connection = 'second_mysql'; // Nama koneksi dari config/database.php
    protected $table = 'schemes'; // Nama tabel yang sesuai dengan database kedua
    protected $fillable = ['name', 'no_scheme'];
    protected $keyType = 'string';
    public $incrementing = false;
}
