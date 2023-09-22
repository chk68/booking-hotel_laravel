<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $fillable = [
        'user_id',
        // Другие атрибуты бронирования
    ];
    protected $table = 'bookings';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
