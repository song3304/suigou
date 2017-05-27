<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model{
	use SoftDeletes;
	
	public $auto_cache = true;
	protected $guarded = ['id'];

	public function shop()
	{
		return $this->belongsTo('App\\Shop', 'sid', 'id');
	}

	public function covers()
	{
		return $this->hasMany('App\\ProductCover', 'pid', 'id');
	}

	public function cover_aids()
	{
		return $this->covers()->get(['cover_aid'])->pluck('cover_aid');
	}

	public function cover()
	{
		return $this->covers()->first();
	}
	
	public function attr_types()
	{
	    return $this->hasMany('App\\ProductAttrType', 'pid', 'id')->with(['attrs']);
	}
	
	public function navigations()
	{
	    return $this->belongsToMany('App\\Navigation', 'shop_products', 'pid', 'nid');
	}
	
	public function scopeOfNavigation(Builder $builder, $nid)
	{
	    $builder->join('shop_products', 'shop_products.pid', '=', 'products.id', 'LEFT');
	    $builder->where('shop_products.nid', $nid)->select('products.*');
	}
}