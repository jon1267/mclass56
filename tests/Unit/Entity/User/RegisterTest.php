<?php

namespace Tests\Unit\Entity\User;

use App\Entity\User;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    public function testRequest(): void
    {
        $user = User::register(
            $name = 'name',
            $email = 'email',
            $password = 'password'
        );

        //$this->assertTrue(true);
        self::assertNotEmpty($user);

        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);

        self::assertNotEmpty($user->password);
        self::assertNotEquals($password, $user->password);

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
    }

    public function testVerify(): void
    {
        $user = User::register('name', 'test2@test.com','password');

        $user->verify();

        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());
    }

    public function testAlreadyVerified(): void
    {
        $user = User::register('name', 'test3@test.com','password');

        $user->verify();

        $this->expectExceptionMessage('User is already verified.');
        $user->verify();
    }
}
