<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BusService;
use App\Models\Bus;
use App\Models\Center;
use App\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BusService $busService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->busService = new BusService();
    }

    public function test_can_create_bus()
    {
        $center = Center::factory()->create();
        
        $data = [
            'number' => 'BUS001',
            'plate_number' => 'ABC-1234',
            'model' => 'Mercedes 2023',
            'capacity' => 30,
            'center_id' => $center->center_name,
            'status' => 'active'
        ];

        $bus = $this->busService->create($data);

        $this->assertInstanceOf(Bus::class, $bus);
        $this->assertEquals('BUS001', $bus->number);
        $this->assertEquals(0, $bus->current_students);
    }

    public function test_cannot_create_bus_with_unavailable_driver()
    {
        $this->expectException(\Exception::class);

        $center = Center::factory()->create();
        $driver = Driver::factory()->create();
        Bus::factory()->create([
            'driver_id' => $driver->id,
            'status' => 'active'
        ]);

        $data = [
            'number' => 'BUS002',
            'plate_number' => 'XYZ-5678',
            'model' => 'Toyota 2023',
            'capacity' => 25,
            'center_id' => $center->center_name,
            'driver_id' => $driver->id,
            'status' => 'active'
        ];

        $this->busService->create($data);
    }

    public function test_can_update_bus()
    {
        $bus = Bus::factory()->create();
        
        $data = ['model' => 'Updated Model'];
        
        $updated = $this->busService->update($bus, $data);

        $this->assertEquals('Updated Model', $updated->model);
    }

    public function test_cannot_delete_bus_with_students()
    {
        $this->expectException(\Exception::class);

        $bus = Bus::factory()->create(['current_students' => 5]);

        $this->busService->delete($bus);
    }

    public function test_can_get_statistics()
    {
        Bus::factory()->count(3)->create(['status' => 'active', 'capacity' => 30]);
        Bus::factory()->count(2)->create(['status' => 'inactive']);

        $stats = $this->busService->getStatistics();

        $this->assertEquals(5, $stats['total_buses']);
        $this->assertEquals(3, $stats['active_buses']);
        $this->assertEquals(90, $stats['total_capacity']);
    }
}