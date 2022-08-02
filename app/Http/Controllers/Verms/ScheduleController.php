<?php

namespace App\Http\Controllers\Verms;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $query = $schedules = Schedule::with(['venue' => function ($query) {
            $query->select("id", "name", "legend");
        }]);
        if (!request()->has('view')) {
            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
            $schedules = $query
                ->whereMonth('start_time', $month)
                ->whereYear('start_time', $year)
                ->get()->makeHidden(['venue_id']);

            return inertia("Verms/Schedules/Index", ['schedules' => $schedules, 'month' => $month, 'year' => $year]);
        }

        if (request()->has('view')) {

            $view = request()->input('view');

            if ($view === 'calendar' && (request()->has('month') && request()->has('year'))) {
                $month = request()->input('month');
                $year = request()->input('year');
                $schedules = $query
                    ->whereMonth('start_time', $month)
                    ->whereYear('start_time', $year)
                    ->get()->makeHidden(['venue_id', 'venue_name']);

                return inertia("Verms/Schedules/Index", ['schedules' => $schedules, 'month' => $month, 'year' => $year]);
            }

            if ($view === 'calendar') {

                $month = Carbon::now()->format('m');
                $year = Carbon::now()->format('Y');
                $schedules = $query->whereMonth('start_time', $month)->get()->makeHidden(['venue_id', 'venue_name']);

                return inertia("Verms/Schedules/Index", ['schedules' => $schedules, 'month' => $month, 'year' => $year]);
            }
        }

        $schedules = Schedule::with(['venue' => function ($query) {
            $query->select("id", "name", "legend");
        }])->get()->makeHidden(['venue_id', 'venue_name']);
        // dd($schedules);
        return inertia("Verms/Schedules/Index", ['schedules' => $schedules]);
    }

    public function create()
    {
        $venues = Venue::select("id", "name")->where('is_publish', true)->get();
        return inertia("Verms/Schedules/Create", ['venues' => $venues]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'venue_id' => 'required',
        ]);

        Schedule::create([
            'venue_id' => $request->venue_id,
            'guest_name' => $request->guest_name,
            'phone_number' => $request->phone_number,
            'event_name' => $request->event_name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
    }
}
