<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ["venue_id", "event_name", "start_time", "end_time", "guest_name", "phone_number"];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
