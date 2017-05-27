<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProduct extends Model{
	
	public $auto_cache = true;
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
	    return $this->hasOne('App\\Product', 'id', 'pid')->with(['covers','shop','attr_types']);
	}
}