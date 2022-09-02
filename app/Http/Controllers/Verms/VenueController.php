<?php

namespace App\Http\Controllers\Verms;

use App\Models\Venue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;


class VenueController extends Controller
{
    public function index()
    {
        $venues = QueryBuilder::for(Venue::class)
            ->select('id', 'name', 'is_publish', 'created_at', 'updated_at')
            ->allowedFilters([
                'name',
                AllowedFilter::callback('venue_search', function (Builder $query, $value) {
                    $query->where('name', 'like', '%' . $value . '%');
                }),
                AllowedFilter::callback('status', function (Builder $query, $value) {
                    switch ($value) {
                        case 'published':
                            $query->where('is_publish', true);
                            break;
                        case 'unpublished':
                            $query->where('is_publish', false);
                            break;
                    }
                })
            ])
            ->defaultSort('-created_at')
            ->allowedSorts(
                'name',
                'created_at',
                'updated_at'
            )
            ->paginate(10)->withQueryString();

        return inertia("Verms/Venues/Index", ['venues' => $venues, 'queries' => request()->query()]);
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
