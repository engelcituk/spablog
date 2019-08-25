<?php

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //un mutador para la contraseña al editar
    public function setPasswordAttribute($password){

        $this->attributes['password']= bcrypt($password);
    }
    public function posts(){
 
        return $this->hasMany(Post::class);
    }

    public function scopePermitidos($query){ //si es admin no le damos restricciones, sino solo los users propios

        if (auth()->user()->can('view',$this)) {
            return $query; //como admin no tiene restricciones le muestro todo el query
        }
        return $query->where('id',auth()->id());
    }
    public function getRoleDisplayNames(){

        return $this->roles->pluck('display_name')->implode(', ');
    }
}
