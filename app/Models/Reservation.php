<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'cottage_id',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'status',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function cottage()
    {
        return $this->belongsTo(Cottage::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
