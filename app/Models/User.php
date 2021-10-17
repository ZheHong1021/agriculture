<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'acc', 'password', 'authority'
    ];

    protected $guarded = [
        'id', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'authority'
    ];

    //輸出身分
    public function getIdentityAttribute(){

        switch ($this->authority) {
            case '1':
                $identity = "最高管理者";
                break;
            case '2':
                $identity = "一般管理者";
                break;    
            case '3':
                $identity = "訪客";
                break;  
            case '4':
                $identity = "停權";
                break;            
            default:
                $identity = "";
                break;
        }

        return $identity;
    }

    public function isSuperAdmin(){
        return $this->authority == 1;
    }

    public function isAdmin(){
        return $this->authority == 2;
    }

    public function isGuest(){
        return $this->authority == 3;
    }
}
