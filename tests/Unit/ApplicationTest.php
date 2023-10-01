<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ApplicationTest extends TestCase
{
   use RefreshDatabase;

//    public function test_manager_can_see_all_applications()
//    {
//         $manager = User::factory()->create([
//             'name' => 'soem',
//             'email' => 'soem@gmail.com',
//             'role' => 'manager',
//             'password' => Hash::make(1234),
//         ]);

//         $response = $this->actingAs($manager)
//                             ->get('api/applications/all');

//         $response->assertStatus(200);
//    }

//    public function test_user_cannot_see_all_applications()
//    {
//         $user = User::factory()->create();

//         $this->actingAs($user, 'api')
//                 ->json('GET', 'api/applications/all')
//                 ->assertStatus(403);
//    }

   public function test_user_can_create_application()
   {
        $user = User::factory()->create();

        $application = [
            'topic' => 'Error',
            'message' => 'Please, help!',
        ];

        $this->actingAs($user, 'api')
                ->json('POST', 'api/applications', $application)
                ->assertStatus(201);
   }
}
