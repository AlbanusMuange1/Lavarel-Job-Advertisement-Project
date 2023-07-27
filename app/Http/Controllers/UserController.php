<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register Form
    public function create(){
      return view('users.register');
    }

    // Create New User
    public function store(Request $request){
      // dd($request);
      $formFields = $request->validate([
        'name' => 'required|min:6',
        'email' => ['required', 'confirmed', 'email', Rule::unique('users', 'email')],
        'password' => 'required|confirmed|min:8',
      ]);

      // Hash Password
      $formFields['password'] = bcrypt($formFields['password']);

      // Create User
      $user = User::create($formFields);

      // Login
      auth()->login($user);
      return redirect('/')->with('success', 'User created and logged in');
    }

    // Logout method
    public function logout(Request $request){
      auth()->logout();

      $request->session()->invalidate();
      $request->session()->regenerateToken();

      return redirect('/')->with('success', 'You have been logged out');

    }

    // Show login form
    public function login(Request $request){
      return view('users.login');
    }

    // Authenticate user
    public function authenticate(Request $request){
      $formFields = $request->validate([
        'email' => ['required', 'email'],
        'password' => 'required'
      ]);
      if (auth()->attempt($formFields)) {
        $request->session()->regenerate();
        return redirect('/')->with('success', 'You are now logged in');
      }
      else {
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
      }
    }
}
