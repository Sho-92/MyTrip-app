<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase; // データベースの状態をリセットするためのトレイト

    public function test_it_can_create_a_user_instance()
    {
        $user = User::factory()->make();
        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->email);
    }

    public function test_it_requires_an_email_to_create_a_user()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        User::factory()->create(['email' => null]);
    }

    public function test_it_requires_a_unique_email()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        User::factory()->create(['email' => 'test@example.com']);
    }

    public function test_it_hashes_the_password_when_creating_a_user()
    {
        $user = User::factory()->create(['password' => 'plainPassword']);
        $this->assertNotEquals('plainPassword', $user->password);
        $this->assertTrue(password_verify('plainPassword', $user->password));
    }

    public function test_it_hides_the_password_when_serializing()
    {
        $user = User::factory()->create(['password' => 'plainPassword']);
        $this->assertArrayNotHasKey('password', $user->toArray());
    }
}