<?php

namespace App;

use App\Model;

class Banner extends Model
{
    protected $guarded = ['id'];
    
    public function shop()
    {
        return $this->hasOne('App\\Shop', 'id', 'sid');
    }
    
    public function navigation()
    {
        return $this->hasOne('App\\Navigation', 'id', 'nid');
    }
    
    public function product()
    {
        return $this->hasOne('App\\Product', 'id', 'pid');
    }
    
}
