<?php

namespace App\Events;

use App\Models\Student;
use App\Models\Bus;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BusAssigned
{
    use Dispatchable, SerializesModels;

    public Student $student;
    public Bus $bus;

    public function __construct(Student $student, Bus $bus)
    {
        $this->student = $student;
        $this->bus = $bus;
    }
}