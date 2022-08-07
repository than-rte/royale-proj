<?php

namespace App\Http\Controllers\Verms;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleV2Controller extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['venue' => function ($query) {
            $query->select('id', "name", "legend");
        }]);

        if ($request->has("date")) {

            $q = $request->query("date");

            if (is_schedule_date($q)) {
                // has valid date
                $date = explode("-", $q);
                $current = Carbon::createFromDate($date[1], $date[0], 1);
                $before = $current->copy()->subMonth()->endOfMonth()->startOfDay();
                $after = $current->copy()->addMonth()->firstOfMonth();

                $schedules = $query->whereBetween('start_time', [$before, $after])
                    ->get()
                    ->makeHidden(['venue_id', 'venue_name']);

                return inertia('Verms/Schedules/V2/Index', ['schedules' => $schedules, 'queries' => $request->query()]);
            }
        }

        return redirect(route("verms.v2.schedules.index", ['date' => Carbon::now()->format('m-Y')]));
    }
}
