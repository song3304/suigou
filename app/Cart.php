<?php

namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    public $auto_cache = true;
	protected $guarded = ['id'];

	public function get($pid, $uid)
	{
	    return $this->where('pid', $pid)->where('uid', $uid)->first();
	}
	
    public function product() {
        return $this->belongsTo('App\\ShopProduct','pid','id')->with(['product']);
    }

    public function user() {
        return $this->belongsTo('App\\User','uid','id');
    }
}
