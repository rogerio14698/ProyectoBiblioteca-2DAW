<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login',
        'rol'
    ];
    public function setPasswordAttribute($value): void
    {
        if (is_string($value) && !Hash::isHashed($value)) {
            $this->attributes['password'] = Hash::make($value);
            return;
        }

        $this->attributes['password'] = $value;
    }
}
