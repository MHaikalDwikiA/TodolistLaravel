<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use App\Services\Impl\TodolistServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();    

        $this->todolistService = $this->app->make(TodolistServiceImpl::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "Eko");

        $todolist =  Session::get('todolist');
        foreach ($todolist as $value){
            self::assertEquals("1", $value['id']);
            self::assertEquals("Eko", $value['todo']);
        }
    }

    public function testTodolistEmpty() 
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testTodolistNotEmpty() 
    {
        $expected = [
            [
            "id" => "1",
            "todo" => "Eko"
        ],
        [
            "id" => "2",
            "todo" => "haikal"
        ]
        ];

        $this->todolistService->saveTodo("1", "Eko");
        $this->todolistService->saveTodo("2", "haikal");

        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo("1", "Eko");
        $this->todolistService->saveTodo("2", "haikal");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));
        
        $this->todolistService->removeTodo("3");
    
        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("1");
    
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("2");
    
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}