<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Tests\TestCase;

class EmailVerificationExample extends TestCase
{
    use RefreshDatabase;

    /**
     * Test sending email verification notification
     */
    public function test_email_verification_can_be_sent()
    {
        // Disable actual mail sending for this test, but still trigger the sending
        Mail::fake();

        // Create a user without email verification
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => null,
        ]);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        // Assert that the verification email was sent
        Mail::assertSent(\Illuminate\Auth\Notifications\VerifyEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        echo "✓ Email verification notification sent successfully to {$user->email}\n";
        $this->assertTrue(true); // Test passes
    }

    /**
     * Example of how to manually send verification email 
     */
    public function test_manual_verification_process()
    {
        Mail::fake();
        
        // Create a new user (this happens during registration)
        $user = User::create([
            'name' => 'Test User',
            'email' => 'newuser@example.com',
            'password' => bcrypt('password123'),
            'role' => 'bendahara',
        ]);

        // Send verification email automatically after registration
        $user->sendEmailVerificationNotification();

        echo "✓ New user created and verification email sent to {$user->email}\n";

        // Refresh the user data from the database
        $user->refresh();

        // Show that the user is not verified yet
        $this->assertNull($user->email_verified_at);
        echo "✓ User email_verified_at is null (not verified yet)\n";

        // Generate the verification URL (this is what would be in the email)
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60), // Valid for 60 minutes
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        echo "✓ Verification URL generated: {$verificationUrl}\n";
        
        // Simulate clicking the verification link
        $response = $this->actingAs($user)->get($verificationUrl);
        
        // Refresh user data after verification
        $user->refresh();
        
        // Verify that the email is now verified
        $this->assertNotNull($user->email_verified_at);
        echo "✓ After verification: email_verified_at is now set to {$user->email_verified_at}\n";
        
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    /**
     * Example of registration flow with email verification
     */
    public function test_registration_with_verification_flow()
    {
        Mail::fake();

        // Simulate user registration
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'securepassword',
            'password_confirmation' => 'securepassword',
        ];

        // Register the user - this would normally be done via the registration form
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'role' => 'bendahara',
        ]);

        // Manually trigger the verification email since it doesn't happen automatically in our model
        $user->sendEmailVerificationNotification();

        // Verify user was created
        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
        ]);

        // Get the created user
        $user = User::where('email', 'jane@example.com')->first();

        // Check that verification email was sent
        Mail::assertSent(\Illuminate\Auth\Notifications\VerifyEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        // Verify user is unverified initially
        $this->assertNull($user->email_verified_at);
        echo "✓ Registration successful, verification email sent to {$user->email}\n";
        echo "✓ User is initially unverified (email_verified_at is null)\n";

        // User cannot access verified routes yet
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertRedirect('/verify-email');
        echo "✓ Unverified user redirected to verification page when accessing dashboard\n";
    }
}