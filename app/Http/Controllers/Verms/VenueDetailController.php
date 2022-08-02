<?php

namespace App\Http\Controllers\Verms;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueDetailController extends Controller
{
    public function index(Venue $venue)
    {
        return inertia("Verms/Venues/Edit/Details", ['venue' => $venue]);
    }

    public function update(Request $request, Venue $venue)
    {
        $request->validate([
            'name' => 'required|string',
            'body' => 'nullable|string',
            'legend' => 'required|string',
            'capacity' => 'required|numeric',
            'is_publish' => 'required|boolean'
        ]);

        $venue->update($request->all());
    }
}
