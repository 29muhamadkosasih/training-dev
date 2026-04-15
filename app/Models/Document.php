<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;
    protected $connection = 'mysql'; // <<< TAMBAHKAN INI
    protected $table = 'documents';
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

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'competence_id');
    }
}
