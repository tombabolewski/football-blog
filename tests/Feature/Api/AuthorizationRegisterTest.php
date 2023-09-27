<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthorizationRegisterTest extends TestCase
{
    /** @test */
    public function canRegister(): void
    {
        $this->postJson(route('api.auth.register'), $this->getCorrectRequestBody())
        ->assertCreated();
        $this->assertEquals(User::all()->count(), 2);
    }

    /** @test */
    public function cannotRegisterWhenPasswordTooShort(): void
    {
        $body = $this->getCorrectRequestBody();
        $body['password'] = $body['password_confirmation'] = '123';
        $this->postJson(route('api.auth.register'), $body)
            ->assertUnprocessable();
        $this->assertEquals(User::all()->count(), 1);
    }

    /** @test */
    public function cannotRegisterWhenEmailInvalid(): void
    {
        $body = $this->getCorrectRequestBody();
        $body['email'] = 'invalid';
        $this->postJson(route('api.auth.register'), $body)
            ->assertUnprocessable();
        $this->assertEquals(User::all()->count(), 1);
    }

    /** @test */
    public function cannotRegisterWhenEmailAlreadyExists(): void
    {
        User::factory()->create([
            'email' => 'john@example.com',
        ]);
        $body = $this->getCorrectRequestBody();
        $this->postJson(route('api.auth.register'), $body)
            ->assertUnprocessable();
        $this->assertEquals(User::all()->count(), 2);
    }

    /** @test */
    public function cannotRegisterWhenNameTooLong(): void
    {
        $body = $this->getCorrectRequestBody();
        $body['name'] = fake()->text(200);
        $this->postJson(route('api.auth.register'), $body)
            ->assertUnprocessable();
        $this->assertEquals(User::all()->count(), 1);
    }

    /** @test */
    public function cannotRegisterWhenPasswordNotConfirmed(): void
    {
        $body = $this->getCorrectRequestBody();
        unset($body['password_confirmation']);
        $this->postJson(route('api.auth.register'), $body)
            ->assertUnprocessable();
        $this->assertEquals(User::all()->count(), 1);
    }

    /** @test */
    public function cannotRegisterWhenPasswordsNotSame(): void
    {
        $body = $this->getCorrectRequestBody();
        $body['password_confirmation'] = 'not-same';
        $this->postJson(route('api.auth.register'), $body)
            ->assertUnprocessable();
        $this->assertEquals(User::all()->count(), 1);
    }

    /** @test */
    public function cannotRegisterWhenNoPassword(): void
    {
        $body = $this->getCorrectRequestBody();
        unset($body['password']);
        $this->postJson(route('api.auth.register'), $body)
            ->assertUnprocessable();
        $this->assertEquals(User::all()->count(), 1);
    }

    /** @test */
    public function cannotRegisterWhenNoEmail(): void
    {
        $body = $this->getCorrectRequestBody();
        unset($body['email']);
        $this->postJson(route('api.auth.register'), $body)
            ->assertUnprocessable();
        $this->assertEquals(User::all()->count(), 1);
    }

    /** @test */
    public function cannotRegisterWhenNoName(): void
    {
        $body = $this->getCorrectRequestBody();
        unset($body['name']);
        $this->postJson(route('api.auth.register'), $body)
            ->assertUnprocessable();
        $this->assertEquals(User::all()->count(), 1);
    }

    protected function getCorrectRequestBody(): array
    {
        return [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
    }
}
