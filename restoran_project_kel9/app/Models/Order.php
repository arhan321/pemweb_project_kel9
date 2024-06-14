<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Set keyType ke string dan incrementing ke false untuk menggunakan UUID
    protected $keyType = 'string';
    public $incrementing = false;

    // Gunakan guarded untuk melindungi atribut mass assignment
    protected $guarded = [];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Override metode boot untuk menghasilkan UUID saat pembuatan model
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Uuid::uuid4();
            }
        });
    }
}
