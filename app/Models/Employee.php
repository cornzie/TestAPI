<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Employee as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;



class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function otp()
    {
        return $this->hasOne(UserOtp::class, 'email', 'email');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'email', 'email');
    }

    public function employeeInfo()
    {
        return $this->hasOne(EmployeeInfo::class);
    }

    public function employer()
    {
        return $this->belongsTo(User::class);
    }
}
