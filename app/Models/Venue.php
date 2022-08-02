<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = ["name", "body", "is_publish", "legend", "capacity"];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
