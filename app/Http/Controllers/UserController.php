<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function Login(){
        return response()
            ->view("user.login", [
                "title" => "login"
            ]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        $user = $request->input('user');
        $password = $request->input('password');

        //validate input password
        if (empty($user) || empty($password)){
            return response()->view("user.login", [
                "title" => "login",
                "error" => "User or password required"
            ]);
        }

        if ($this->userService->login($user, $password)){
            $request->session()->put("user", $user);
            return redirect("/");
        }

        return response()->view("user.login", [
            "title" => "Login",
            "error" => "User or password required"
        ]);
    }

    public function doLogout(Request $request)
    {
        request()->session()->forget("user");
        return redirect("/");
    }
}
