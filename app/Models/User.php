<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function firstLatter()
    {

        // Example string
        $inputString = auth()->user()->name;

        // Split the string into an array of words
        $words = explode(' ', $inputString);


        // Initialize an empty string to hold the first letters
        $nameIcon = '';

        // Loop through each word and get the first letter
        for ($i = 0; $i < 2; $i++) {
            if (!empty($words[$i])) {
                $nameIcon .= strtoupper($words[$i][0]);
            }
        }
        return $nameIcon;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
