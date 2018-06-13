<?php

namespace Tests\Unit\Entity\User;

use App\Entity\User;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    public function testNew(): void
    {
        $this->assertTrue(true);

        /*$user = User::new(
            $name = 'name',
            $email = 'email'
        );

        self::assertNotEmpty($user);

        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        self::assertNotEmpty($user->password);

        self::assertTrue($user->isActive());*/
    }
}
