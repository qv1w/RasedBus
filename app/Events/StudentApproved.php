<?php

namespace App\Events;

use App\Models\Student;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentApproved
{
    use Dispatchable, SerializesModels;

    public Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }
}