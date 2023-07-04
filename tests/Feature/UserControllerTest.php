<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
  public function testLoginPage()
  {
    $this->get('/login')
        ->assertSeeText("Login");
  }

  public function testLoginPageForMamber()
  {
    $this->withSession([
        "user" => "haikal"
    ])->get('/login')
        ->assertRedirect("/");
  }

  public function testLoginSuccess()
  {

    $this->post("/login", [
        "user" => "haikal",
        "password" => "kali",
    ])->assertRedirect("/")
        ->assertSessionHas("user", "haikal");
  }

  public function testLoginForUserAlreadyLogin()
  {
    $this->withSession([
        "user" => "haikal"
    ])->post("/login", [
        "user" => "haikal",
        "password" => "kali",
    ])->assertRedirect("/");
  }

  public function testLoginValidationError()
  {
    $this->post("/login", [])
        ->assertSeeText("User or password required");
  }

  public function testLoginFailed()
  {
    $this->post("/login", [
        'user' => 'wrong',
        'password' => 'wrong',
    ])->assertSeeText("User or password required");
  }

  public function testLogOut(){
    $this->withSession([
        "user" => 'haikal'
    ])->post('/logout')
        ->assertRedirect("/")
        ->assertSessionMissing("user");
  }
  public function testLogOutMember()
  {
     $this->post('/logout')
        ->assertRedirect("/");
   }
}