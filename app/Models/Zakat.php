<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Zakat extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'invoice', 'category_id', 'muzakki_id', 'amount', 'pray', 'status', 'struk', 'alasan_penolakan'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class);
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-Y');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-Y');
    }
}
