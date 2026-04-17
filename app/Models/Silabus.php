<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Silabus extends Model
{
    use HasFactory;
    protected $connection = 'mysql'; // <<< TAMBAHKAN INI
    protected $table = 'silabus';
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        // Generate UUID saat model sedang dibuat
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
    
    public function unitKompetensi()
    {
        return $this->belongsTo(CompetenceCode::class, 'unit_kompetensi_id');
    }
}
