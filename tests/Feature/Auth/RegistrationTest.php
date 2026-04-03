<?php

test('new users can register', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response
        ->assertCreated()
        ->assertJsonStructure(['token', 'user' => ['id', 'name', 'email']]);
});
