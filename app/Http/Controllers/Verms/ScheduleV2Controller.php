<?php

namespace App\Http\Controllers\Verms;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ScheduleV2Controller extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('filter.month_year')) {
            return redirect()->route('verms.v2.schedules.index', ['filter' => ['month_year' => Carbon::now()->format('m-Y')]]);
        }

        $schedules = QueryBuilder::for(Schedule::class)
            ->allowedFilters([
                AllowedFilter::callback('month_year', function (Builder $query, $value) {
                    $monthYear = explode("-", $value);
                    $current = Carbon::createFromDate($monthYear[1], $monthYear[0], 1);
                    $before = $current->copy()->subMonth()->endOfMonth()->startOfDay();
                    $after = $current->copy()->addMonth()->firstOfMonth();
                    $query->whereBetween('start_time', [$before, $after]);
                }),
                AllowedFilter::callback('status', function (Builder $query, $value) {
                    if ($value !== 'all') {
                        $query->where('status', $value);
                    }
                }),

            ])
            ->whereHas('venue', function ($query) use ($request) {
                if ($request->input('venue') !== 'all') {
                    $query->where('name', 'like', $request->input('venue'));
                }
            })
            ->with(['venue' => function ($query) {
                $query->select('id', "name", "legend");
            }])->get()->makeHidden(['venue_id', 'venue_name']);

        $venues = Venue::select('id', 'name')->get();

        return inertia('Verms/Schedules/V2/Index', ['schedules' => $schedules, 'venues' => $venues, 'queries' => $request->query()]);
    }
}
