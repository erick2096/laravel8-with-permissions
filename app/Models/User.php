<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

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

    public function getModulesAvailable(): array
    {
        $modulesAvailable = [];
        $csr = Role::findByName('csr');
        $csrPermissions = $csr->permissions;
        $teller = Role::findByName('teller');
        $tellerPermissions = $teller->permissions;

        if ($this->hasRole("admin")) {
            return ["csr", "teller"];
        }

        if ($this->hasAnyPermission($csrPermissions)) {
            $modulesAvailable[] = "csr";
        }

        if ($this->hasAnyPermission($tellerPermissions)) {
            $modulesAvailable[] = "teller";
        }

        return $modulesAvailable;
    }
}
