<?php
/**
 * App\Models\Admin
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static create(array $attributes = [])
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $last_login
 * @property string|null $rol
 * @property bool $is_demo
 */

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
        'rol',
        'is_demo'
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
