<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GeneralInformation extends Model
{
    use HasFactory;
    protected $connection = 'mysql'; // <<< TAMBAHKAN INI
    protected $table = 'general_informations';
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
}
