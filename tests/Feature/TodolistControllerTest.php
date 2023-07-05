<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "haikal",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Eko"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Eko");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "haikal"
        ])->post("/todolist", [])
            ->assertSeeText("");
        }

    public function testAddTodoSucces()
    {
        $this->withSession([
            "user" => "Eko",
        ])->post("/todolist", [
            "todo" => "haikal"
        ])->assertRedirect("/todolist");
    }
}
