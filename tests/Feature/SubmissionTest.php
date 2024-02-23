<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testSubmitSubmission(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'message' => 'secret',
        ];

        $response = $this->post('/api/submit', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('submissions', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }
}
