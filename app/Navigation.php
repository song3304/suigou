<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Navigation extends Model{
	use SoftDeletes;
	public $auto_cache = true;
	protected $guarded = ['id'];

	public function shops()
	{
		return $this->hasOne('App\\Shop', 'id', 'sid');
	}

	public function shop_products()
	{
		return $this->hasMany('App\\ShopProduct', 'nid', 'id')->with(['product']);
	}
}