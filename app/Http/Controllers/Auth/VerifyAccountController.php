<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;

use Illuminate\Support\Facades\Auth;

class VerifyAccountController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|min:6'
        ]);

        $user = Auth::user();

        if($request->otp == $user->otp->otp)
        {
            $userObj = User::where('id', $user->id)->first();
            
            $userObj->verified = TRUE;
            $userObj->account_no = 'EMP'.rand(100000000000, 999999999999);

            //send the account no in a mail
            
            if($userObj->save()){

                return response()->json([
                    'status' => 'success'
                ], 204);
            } else {
                return response()->json([
                    'status' => 'error',
                ], 400);

            }
        }

        return response()->json([
            'status' => 'error',
        ], 400);

    }

    public function employeeVerify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|min:6'
        ]);

        $user = Auth::user();

        if($request->otp == $user->otp->otp)
        {
            $userObj = Employee::where('id', $user->id)->first();
            
            $userObj->verified = TRUE;
            $userObj->account_no = 'EEM'.rand(100000000000, 999999999999);

            //send the account no in a mail
            
            if($userObj->save()){

                return response()->json([
                    'status' => 'success'
                ], 204);

            } else {

                return response()->json([
                    'status' => 'error',
                ], 400);

            }
        }

        return response()->json([
            'status' => 'error',
        ], 400);

    }
}
