<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Bus;
use App\Models\Center;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // تسجيل دخول admin
        $admin = Admin::factory()->create();
        session(['admin_id' => $admin->id, 'admin_logged_in' => true]);
    }

    public function test_can_view_buses_index()
    {
        Bus::factory()->count(3)->create();

        $response = $this->get(route('admin.buses.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.buses.index');
        $response->assertViewHas('buses');
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

        $response = $this->post(route('admin.buses.store'), $data);

        $response->assertRedirect(route('admin.buses.index'));
        $this->assertDatabaseHas('buses', ['number' => 'BUS001']);
    }

    public function test_cannot_create_bus_with_invalid_data()
    {
        $data = [
            'number' => '', // مطلوب
            'plate_number' => 'ABC',
            'capacity' => 5 // أقل من الحد الأدنى
        ];

        $response = $this->post(route('admin.buses.store'), $data);

        $response->assertSessionHasErrors(['number', 'capacity']);
    }

    public function test_can_update_bus()
    {
        $bus = Bus::factory()->create();

        $data = ['model' => 'Updated Model'];

        $response = $this->put(route('admin.buses.update', $bus), array_merge($bus->toArray(), $data));

        $response->assertRedirect(route('admin.buses.show', $bus));
        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'model' => 'Updated Model']);
    }

    public function test_can_delete_bus()
    {
        $bus = Bus::factory()->create(['current_students' => 0]);

        $response = $this->delete(route('admin.buses.destroy', $bus));

        $response->assertRedirect(route('admin.buses.index'));
        $this->assertDatabaseMissing('buses', ['id' => $bus->id]);
    }
}