<?php
namespace App;

use App\Model;

class UserAddress extends Model{
	public $auto_cache = true;
	protected $guarded = ['id'];

	protected $dates = ['used_at'];
	protected $appends = ['full_address'];

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

	public function user()
	{
	    return $this->hasOne('App\\User','id','uid');
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