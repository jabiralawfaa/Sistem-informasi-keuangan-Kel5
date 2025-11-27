<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

uses(\Tests\TestCase::class, RefreshDatabase::class);

it('can send email verification to a user', function () {
    Mail::fake(); // Fake mail for testing purposes

    $user = User::factory()->create([
        'email_verified_at' => null, // User has not verified their email
    ]);

    // Send email verification notification
    $user->sendEmailVerificationNotification();

    // Assert that an email was sent
    Mail::assertSent(\Illuminate\Auth\Notifications\VerifyEmail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });

    $this->assertTrue(true); // Test passes if email verification was sent
});

it('can verify user email with valid verification link', function () {
    $user = User::factory()->create([
        'email_verified_at' => null, // User has not verified their email
    ]);

    // Get the email verification URL
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]
    );

    // Visit the verification URL
    $response = $this->actingAs($user)->get($verificationUrl);

    // Refresh the user from the database
    $user->refresh();

    // Assert that the email is now verified
    $this->assertNotNull($user->email_verified_at);
    $response->assertRedirect(route('dashboard', absolute: false));
});

it('redirects unverified users to verification notice', function () {
    $user = User::factory()->create([
        'email_verified_at' => null, // User has not verified their email
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect('/verify-email');
});

it('allows verified users to access dashboard', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(), // User has verified their email
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
});

it('can resend verification email', function () {
    Mail::fake();

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $response = $this->actingAs($user)
        ->post('/email/verification-notification');

    $response->assertNoContent();

    Mail::assertSent(\Illuminate\Auth\Notifications\VerifyEmail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
});