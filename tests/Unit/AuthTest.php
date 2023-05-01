<?php

namespace Altenic\MaybeCms\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Altenic\MaybeCms\Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_unauthorized()
    {
        $this->postJson('/api/login')
            ->assertUnauthorized();
    }

    public function test_login_success()
    {
        $email = fake()->safeEmail();
        $password = Str::random(8);
        $this->userFactory->state([
            'email' => $email,
            'password' => Hash::make($password),
        ])->admin()->create();
        $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'name',
                'email',
                'token',
            ]);
    }

    public function test_logout_unauthorized()
    {
        $this->postJson('/api/logout')
            ->assertUnauthorized();
    }

    public function test_logout_success()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/logout')
            ->assertSuccessful();
    }
}
