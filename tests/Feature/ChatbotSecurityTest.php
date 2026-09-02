<?php

namespace Tests\Feature;

use Tests\TestCase;

class ChatbotSecurityTest extends TestCase
{
    public function test_chatbot_requires_a_bounded_message(): void
    {
        $this->postJson('/chatbot')
            ->assertStatus(422)
            ->assertJsonValidationErrors('message');

        $this->postJson('/chatbot', [
            'message' => str_repeat('a', 1001),
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('message');
    }
}