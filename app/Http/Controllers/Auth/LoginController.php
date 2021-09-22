<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
   public function login(Request $request)
   {
       $request->validate([
           'email' => 'email|required',
           'password' => 'string|required'
       ]);
       
       $user = User::where('email', $request->email)->first() ? User::where('email', $request->email)->first() : Employee::where('email', $request->email)->first();

       if(Auth::attempt($request->only('email', 'password')) || Auth::guard('employees')->attempt($request->only('email', 'password')))
       {
           return response()->json([
               'status' => 'success',
               'user' => $user,
               'token' => $user->createToken($request->email)->plainTextToken,
           ], 200);

       }

       return response()->json([
           'status' => 'error',
           'message' => 'No such records in our DB'
       ], 400);
   }
}
