<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttr extends Model{
	use SoftDeletes;
	public $auto_cache = true;
	protected $guarded = ['id'];

// 	public function product()
// 	{
// 		return $this->belongsTo('App\\Product', 'pid', 'id');
// 	}
	
	public function attr_types()
	{
		return $this->belongsTo('App\\ProductAttrType','tid','id');
	}
}