<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp():void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function testSample()
    {
        self::assertTrue(true);
    }

    public function testLoginSucces()
    {
        self::assertTrue($this->userService->login("haikal", "kali"));
    }

    public function testLoginFailed()
    {
        self::assertFalse($this->userService->login("khanedy", "ikal"));
    }

    public function testLoginPasswordWrong()
    {
        self::assertFalse($this->userService->login("haikal", "apaan"));
    }
}
