<?php
namespace App;

use App\Model;

class SocialiteUser extends Model 
{
    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->hasOne('App\\User', 'id', 'user_id');
    }
}
