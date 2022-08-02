<?php

namespace App\Http\Controllers\Verms;

use App\Models\Venue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class VenueController extends Controller
{
    public function index()
    {
        $venues = QueryBuilder::for(Venue::class)
            ->select('id', 'name', 'is_publish', 'created_at', 'updated_at')
            ->allowedFilters(['name', AllowedFilter::exact('is_publish'),])
            ->defaultSort('-created_at')
            ->allowedSorts('name', '-created_at', '-updated_at')
            ->paginate(10)->withQueryString();
        return inertia("Verms/Venues/Index", ['venues' => $venues]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Venue::create([
            'name' => $request->name,
        ]);
    }

    public function show(Venue $venue)
    {
        $venues = QueryBuilder::for(Venue::class)
            ->select('id', 'name', 'is_publish', 'created_at', 'updated_at')
            ->allowedFilters(['name', AllowedFilter::exact('is_publish'),])
            ->defaultSort('-created_at')
            ->allowedSorts('name', '-created_at', '-updated_at')
            ->paginate(10)->withQueryString();
        return inertia("Verms/Venues/Index", ['venues' => $venues, 'venue' => $venue, 'modal' => true]);
    }
}
