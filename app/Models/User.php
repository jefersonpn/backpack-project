<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use CrudTrait;
    use HasFactory, Notifiable;

    // Define constants for user types
    const TYPE_SUPERADMIN = '1';
    const TYPE_ADMIN = '2';
    const TYPE_USER = '3';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type', // Ensure type is fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type === self::TYPE_ADMIN ||
            $this->type === self::TYPE_SUPERADMIN;
    }

    /**
     * Determine if the user is a super administrator.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->type === self::TYPE_SUPERADMIN;
    }

    /**
     * Determine if the user is an ordinary user.
     *
     * @return bool
     */
    public function isUser()
    {
        return $this->type === self::TYPE_USER;
    }

    public function getTypeLabelAttribute()
    {
        switch ($this->type) {
            case '1':
                return 'Superadmin';
            case '2':
                return 'Admin';
            case '3':
                return 'User';
            default:
                return 'Unknown';
        }
    }

}
