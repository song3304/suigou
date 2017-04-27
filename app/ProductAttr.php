<?php
namespace App;

use Addons\Core\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plugins\Activity\App\ActivityType;
use Plugins\Activity\App\Activity;

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