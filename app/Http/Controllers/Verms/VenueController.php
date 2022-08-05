<?php

namespace App\Http\Controllers\Verms;

use App\Models\Venue;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;


class VenueController extends Controller
{
    public function index()
    {
        // dd(request()->all());
        // $venues = QueryBuilder::for(Venue::class)
        //     ->select('id', 'name', 'is_publish', 'created_at', 'updated_at')
        //     ->allowedFilters(['name', AllowedFilter::exact('is_publish'),])
        //     ->defaultSort('-created_at')
        //     ->allowedSorts(
        //         'name',
        //         'created_at',
        //         'updated_at'
        //     )
        //     ->paginate(10)->withQueryString();

        $venues = QueryBuilder::for(Venue::class)
            ->select('id', 'name', 'is_publish', 'created_at', 'updated_at')
            ->allowedFilters([
                'name',
                AllowedFilter::callback('venue_search', function(Builder $query, $value) {
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

        // dd($venues);

        // $venues = QueryBuilder::for(Venue::class)
        //     ->select('id', 'name', 'is_publish', 'created_at', 'updated_at')
        //     ->allowedFilters(['name', AllowedFilter::exact('is_publish'),])
        //     ->defaultSort('-created_at')
        //     ->allowedSorts(
        //         AllowedSort::field('venue_search', 'name'),
        //         AllowedSort::field('new', 'created_at'),
        //         'updated_at'
        //     )
        //     ->paginate(10)->withQueryString();
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
