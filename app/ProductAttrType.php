<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttrType extends Model{
	use SoftDeletes;
	public $auto_cache = true;
	protected $guarded = ['id'];
    //属于一个商品
	public function product()
	{
	    return $this->belongsTo('App\\Product', 'pid', 'id');
	}
	//拥有商品库存表 一对多
	public function attrs()
	{
	    return $this->hasMany('App\\ProductAttr','tid','id');
	}
	
}