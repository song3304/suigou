<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Navigation extends Model{
	use SoftDeletes;
	public $auto_cache = true;
	protected $guarded = ['id'];

	public function shop()
	{
		return $this->hasOne('App\\Shop', 'id', 'sid');
	}

	public function products()
	{
		return $this->belongsToMany('App\\Product', 'shop_products', 'nid', 'pid');
	}
}