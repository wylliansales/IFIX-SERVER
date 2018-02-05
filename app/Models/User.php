<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 * @property boolean activeted
 * @property Json scopes
 * @property string $remember_token
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class User extends Authenticatable implements Transformable
{
    use TransformableTrait, HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token', 'scopes'];
    protected $guarded = ['scopes'];
    protected $casts = ['scopes' => 'array',];
    protected $dates = ['deleted_at'];
    

    public function administrator()
    {
        $this->hasOne('App\Models\Administrator');
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }
}
