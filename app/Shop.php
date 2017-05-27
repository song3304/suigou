<?php
namespace App;

use App\Model;

class Shop extends Model{
	public $auto_cache = true;
	protected $guarded = [];
	protected $appends = ['full_address'];
	
	const AUDITING = 0;
	const ON = 1;
	const OFF = -1;

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
	//门店状态
	public function status_tag()
	{
	    $tag = '';
	    switch ($this->status){
	        case static::AUDITING:
	            $tag = '审核中';break;
	        case static::ON:
	            $tag = '审核通过';break;
	        case static::OFF:
	            $tag = '已关闭';break;
	        default:
	            $tag = '未知';break;	      
	    }
	    return $tag;
	}
	
	public function full_address($format = '%P%C%D %A')
	{
	    $data = [
	        '%P' => $this->province_name->area_name,
	        '%C' => $this->city_name->area_name,
	        '%D' => $this->area_name->area_name,
	        '%A' => $this->address,
	    ];
	    return strtr($format, $data);
	}
	
	public function getFullAddressAttribute()
	{
	    return $this->full_address();
	}
	//省
	public function province_name()
	{
	    return $this->hasOne('App\\Area', 'area_id', 'province');
	}
	//市
	public function city_name()
	{
	    return $this->hasOne('App\\Area', 'area_id', 'city');
	}
	//区
	public function area_name()
	{
	    return $this->hasOne('App\\Area', 'area_id', 'area');
	}
}