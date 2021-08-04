<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class CustomAuthController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect('customers');
        }

        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $validator = $request->validate([
            'account' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $fieldType = filter_var($request->account, FILTER_VALIDATE_EMAIL) ? 'email' : 'account';

        if (Auth::attempt(array($fieldType => $request->account, 'password' => $request->password))) {
            return redirect()->intended('customers')
                        ->withSuccess('Signed in');
        }

        return redirect()->route('login')
        ->with('error','Email-Address And Password Are Wrong.');
    }

    public function registration()
    {
        if(Auth::check()){
            return redirect('customers');
        }

        return view('auth.register');
    }

    public function customRegistration(Request $request)
    {  
        $data = $request->all();
        // dd(1);
        $request->validate([
            'name' => 'required',
            'account' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        $check = $this->create($data);
         
        return redirect()->intended('customers')->withSuccess('Signed in');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'account' => $data['account'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
