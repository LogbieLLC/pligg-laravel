<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->unverified()->create();

        Event::fake();

        /** @var int $userId */
        $userId = $user->getKey();
        /** @var string $userEmail */
        $userEmail = $user->getAttribute('email');

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $userId, 'hash' => sha1($userEmail)]
        );

        /** @var \App\Models\User|null $freshUser */
        $freshUser = $user->fresh();
        if (!$freshUser) {
            $this->fail('User not found after creation');
        }

        $response = $this->actingAs($freshUser)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($freshUser->hasVerifiedEmail());
        $response->assertRedirect(route('dashboard', absolute: false) . '?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->getKey(), 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
