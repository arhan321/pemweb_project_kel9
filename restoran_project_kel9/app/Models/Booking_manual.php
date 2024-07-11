<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking_manual extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'booking_manuals';

    public const CATEGORY_SELECT = [
        'reservasi'   => 'reservasi',
    ];

    protected $dates = [
        'start_book',
        'finish_book',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'Cancel'    => 'Cancel',
        'Booking'   => 'Booking',
        'Selesai'   => 'Selesai',
    ];

    protected $fillable = [
        'nama_customer',
        'jumlah_orang',
        'start_book',
        'finish_book',
        'category',
        'customer_email',
        'phone',
        'total_price',
        'status',
        'table_id', 
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getStartBookAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function setStartBookAttribute($value)
    {
        $this->attributes['start_book'] = $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function getFinishBookAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function setFinishBookAttribute($value)
    {
        $this->attributes['finish_book'] = $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
