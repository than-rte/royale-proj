<?php

namespace App\Http\Controllers\Verms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return inertia("Verms/Events/Index");
    }
}
