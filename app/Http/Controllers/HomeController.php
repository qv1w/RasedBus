<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\Center;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'centers_count' => Center::count(),
            'students_count' => Student::count(),
            'buses_count' => Bus::count(),
            'drivers_count' => Driver::count(),
        ];

        return view('welcome', compact('stats'));
    }
}