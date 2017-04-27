<?php
namespace App;

use App\Model;

class Shop extends Model{
	public $auto_cache = true;
	protected $guarded = [];

	public function user()
	{
		return $this->hasOne('App\\User', 'id', 'id');
	}
	//会员
	public function members()
	{
		return $this->belongsToMany('App\\User', 'shop_users', 'sid', 'uid');
	}

	public function member_ids()
	{
		return $this->members()->get(['users.id'])->pluck('id');
	}

	public function products()
	{
	    return $this->belongsToMany('App\\Product', 'shop_products','sid', 'pid');
	}
	
	public function product_ids()
	{
	    return $this->products()->get(['products.id'])->pluck('id');
	}
	
	public function orders()
	{
		return $this->hasMany('App\\Order', 'sid', 'id');
	}
}