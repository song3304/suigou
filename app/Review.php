<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Addons\Core\Models\Tree;

class Review extends Tree
{
    public $auto_cache = false;
    protected $guarded = ['id'];
    
    public function products()
	{
		return $this->hasOne('App\\Product', 'id', 'product_id');
	}
	
	public function users()
	{
	    return $this->hasOne('App\User','id','user_id');
	}
}
