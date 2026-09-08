<?php

namespace App\Listeners;

use App\Events\StudentApproved;
use App\Models\Center;

class UpdateCenterStatistics
{
    public function handle(StudentApproved $event): void
    {
        $center = Center::where('center_name', $event->student->center)->first();
        
        if ($center) {
            $center->updateCounts();
        }
    }
}