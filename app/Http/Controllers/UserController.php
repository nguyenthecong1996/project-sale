<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $data = [   
            'name' => $request->name, 
            'phone' => $request->phone,
            'email' => $request->email,
            'account' => $request->account,
        ];

        User::updateOrCreate(['id' => $request->user_id], $data);
    }
}
