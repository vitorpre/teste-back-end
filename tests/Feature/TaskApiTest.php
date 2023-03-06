<?php
/**
 * Created by PhpStorm.
 * User: Vitor
 * Date: 06/03/2023
 * Time: 13:25
 */

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    public function testApiCreate()
    {
        $data = [
            'title' => 'Test',
            'description' => 'test@example.com',
            'start_date' => '2022-05-10',
            'conclusion_date' => '2023-09-25'
        ];
        $response = $this->post('/api/tasks', $data, ['Authorization' => 'Bearer ' . $this->getToken()]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testApiRead()
    {
        $task = Task::factory()->create();
        $response = $this->get('/api/tasks/' . $task->id, ['Authorization' => 'Bearer ' . $this->getToken()]);
        $response->assertStatus(200);
        $response->assertJson($task->toArray());
    }

    public function testApiUpdate()
    {
        $task = Task::factory()->create();
        $data = [
            'title' => 'Updated',
            'description' => 'updated description',
            'start_date' => '2022-05-30',
            'conclusion_date' => '2023-01-10'
        ];
        $response = $this->put('/api/tasks/' . $task->id, $data, ['Authorization' => 'Bearer ' . $this->getToken()]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testApiDelete()
    {
        $task = Task::factory()->create();
        $response = $this->delete('/api/tasks/' . $task->id, [], ['Authorization' => 'Bearer ' . $this->getToken()]);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', $task->toArray());
    }

    private function getToken() {
        $user = User::factory()->create();
        $token = auth()->login($user);

        return $token;
    }
}
