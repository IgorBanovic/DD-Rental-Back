<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;

test('email can be verified', function () {
    $user = User::factory()->unverified()->create();

    Event::fake();
    Sanctum::actingAs($user);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->getJson($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertOk()->assertJson(['status' => 'verified']);
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();
    Sanctum::actingAs($user);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->getJson($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
