<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\UserOTP;
use App\Models\Employee;
use App\Models\EmployeeInfo;
use App\Mail\VerifyAccount;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|min:3|unique:users,email',
            'mobile' => 'required|string|min:3',
            'office_address' => 'required|string|min:3',
            'password' => 'required|string|confirmed|string|min:3',
            'type' => 'nullable|string'
        ]);

        try
        {

            if($request->has('type') && $request->type === 'employer')
            {
                if( ! $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'office_address' => $request->office_address,
                    'password' => Hash::make($request->password),
                ]) )
                {
                    throw new \Exception;
                }
            }
            elseif ($request->has('type') && $request->type === 'employee')
            {
                $user = Employee::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'user_id' => $request->user_id,
                    'password' => Hash::make($request->password),
                ]);

                $employeeInfo = EmployeeInfo::create([
                    'employee_id' => $user->id
                ]);
                
                if( ! $user )
                {
                    throw new \Exception;
                }

            }

            //send OTP
            $otp = UserOTP::create([
                'email' => $user->email,
                'otp' => rand(100000, 999999),
            ]);

            //Mail::to($user->email)->send(new VerifyAccount($otp));

            //response
            return response()->json($user, 201);

        }
        catch(\Exception $e)
        {

            \Log::critical('User registration failed', [
                'REQUEST' => $request,
                'MSG' => $e->getMessage()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    

}
