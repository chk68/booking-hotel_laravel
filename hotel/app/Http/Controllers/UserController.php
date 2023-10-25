<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        // Получите данные пользователя, которые вы хотите отобразить
        $user = auth()->user();

        return view('profile.show', ['user' => $user]);
    }
}
