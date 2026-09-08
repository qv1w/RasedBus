<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\StudentService;
use App\Models\Student;
use App\Models\Center;
use App\Models\Bus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected StudentService $studentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->studentService = new StudentService();
    }

    public function test_can_create_student()
    {
        $center = Center::factory()->create([
            'center_name' => 'دار الفوزان',
            'status' => 'active',
            'morning_available' => true
        ]);

        $data = [
            'name' => 'فاطمة أحمد',
            'national_id' => '1234567890',
            'birthdate' => '2010-01-01',
            'email' => 'fatima@example.com',
            'mobile' => '0501234567',
            'guardian_name' => 'أحمد محمد',
            'guardian_mobile' => '0509876543',
            'preferred_schedule' => 'صباحية',
            'center' => $center->center_name,
            'latitude' => 26.3025,
            'longitude' => 44.8152
        ];

        $student = $this->studentService->create($data);

        $this->assertInstanceOf(Student::class, $student);
        $this->assertEquals('pending', $student->status);
        $this->assertNotNull($student->student_id);
    }

    public function test_can_approve_student()
    {
        $student = Student::factory()->create(['status' => 'pending']);

        $approved = $this->studentService->approve($student);

        $this->assertEquals('approved', $approved->status);
    }

    public function test_can_assign_bus_to_student()
    {
        $student = Student::factory()->create(['status' => 'approved']);
        $bus = Bus::factory()->create([
            'status' => 'active',
            'center_id' => $student->center,
            'capacity' => 30,
            'current_students' => 0
        ]);

        $result = $this->studentService->assignBus($student, $bus->id);

        $this->assertEquals($bus->id, $result->assigned_bus_id);
        $this->assertEquals(1, $bus->fresh()->current_students);
    }

    public function test_can_unassign_bus()
    {
        $bus = Bus::factory()->create(['current_students' => 1]);
        $student = Student::factory()->create([
            'assigned_bus_id' => $bus->id
        ]);

        $result = $this->studentService->unassignBus($student);

        $this->assertNull($result->assigned_bus_id);
        $this->assertEquals(0, $bus->fresh()->current_students);
    }
}