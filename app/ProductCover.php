<?php
namespace App;

use Addons\Core\Models\Model;

class ProductCover extends Model{
	public $auto_cache = true;
	protected $guarded = ['id'];

	public function product()
	{
		return $this->belongsTo('App\\Product', 'pid', 'id');
	}
}