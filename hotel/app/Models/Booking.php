<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $fillable = ['user_id', 'room_id', 'check_in', 'check_out'];

    protected $table = 'bookings';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';

}
