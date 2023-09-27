<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthorizationLoginTest extends TestCase
{
    /**
     * @test
     * @dataProvider authorizationProvider
     */
    public function authorize(callable $userFn, int $expectedStatus): void
    {
        /** @var User $user */
        $user = $userFn();
        $r = $this->postJson(route('api.auth.login'), [
            'email' => $user->email,
            'password' => UserFactory::PASSWORD,
        ])->assertStatus($expectedStatus);
    }

    public static function authorizationProvider(): array
    {
        return [
            'User cannot login' => [
                'userFn' => fn() => User::factory()->create(),
                'expectedStatus' => Response::HTTP_FORBIDDEN,
            ],
            'Journalist can login' => [
                'userFn' => fn() => User::factory()->journalist()->create(),
                'expectedStatus' => Response::HTTP_OK,
            ],
            'Admin can login' => [
                'userFn' => fn() => User::factory()->admin()->create(),
                'expectedStatus' => Response::HTTP_OK,
            ],
        ];
    }
}
