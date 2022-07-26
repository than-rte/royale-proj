<?php

namespace App\Http\Controllers\Verms;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueMediaController extends Controller
{
    public function index(Venue $venue)
    {
        return inertia("Verms/Venues/Edit/Media", ['venue' => $venue]);
    }
}
