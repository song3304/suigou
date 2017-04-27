<?php
namespace App;

use Addons\Core\Models\Model;

class OrderDetail extends Model{
	public $auto_cache = true;
	protected $guarded = ['id'];
	protected $appends = ['money'];


	public function product()
	{
		return $this->hasOne('App\\Product',  'id', 'pid')->withTrashed();
	}

	public function getMoneyAttribute()
	{
		return $this->unit_price * $this->count;
	}


}