<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SilabusDetail extends Model
{
    use HasFactory;
    protected $connection = 'mysql'; // <<< TAMBAHKAN INI
    protected $table = 'silabus_details';
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

    public function silabus()
    {
        return $this->belongsTo(Silabus::class, 'silabus_id');
    }

    public function element()
    {
        return $this->belongsTo(CompetenceCodeElement::class, 'element_id');
    }
}
