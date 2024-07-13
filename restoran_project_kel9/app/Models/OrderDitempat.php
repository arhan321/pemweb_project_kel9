<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDitempat extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'order_ditempats';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'Belum bayar' => 'Belum bayar',
        'Sudah bayar' => 'Sudah bayar',
    ];

    protected $fillable = [
        'nama_pemesan',
        'product',
        'price',
        'jam_pesan',
        'tanggal_pesan',
        'table_id',
        'status_bayar',  // Tambahkan ini
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
