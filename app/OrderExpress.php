<?php
namespace App;

use Addons\Core\Models\Model;

class OrderExpress extends Model{
	public $auto_cache = true;
	protected $guarded = [];

	public function order()
	{
		return $this->hasOne('App\\Order', 'id', 'id');
	}
	
	public function express_types(){
	    return $this->hasOne('App\\Field','id','express_name');
	}
	
	public function express_type_names(){
	    return $this->hasOne('App\\Field','id','express_type');
	}
	
	public function salons(){
	    return $this->hasOne('App\\BeautySalon','id','mid')->with('user');
	}
	
	public function user_address(){
	    return $this->hasOne('App\\UserAddress','id','uaid');
	}
}