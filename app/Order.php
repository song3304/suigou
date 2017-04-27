<?php
namespace App;

use App\Model;
use App\OrderExpress;
use App\User;
use App\Shop;
use App\Bill;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
 
class Order extends Model{
	use SoftDeletes;
	public $auto_cache = true;
	protected $guarded = ['id'];
	
	const UNKNOWN = 0; //未知
	const INIT = 1; //商品确认
	const CANCELED = -1; //订单已取消
	const PAID = 2; //订单已支付
	const REFUSED = -2; //订单退款
	const DELIVERED = 3; //订单已发货
	const DEALT = 4; //已确认收货/成交
	const REJECTED = -4; //已拒绝收货
	const CLOSED = -5; //关闭
	const COMPARE_BILL_FAIL = -20; //对账失败

	const PAY_ALIPAY = 1;
	const PAY_WEIXIN= 2;
	const PAY_OFFLINE = 9;
	 
	public function order_status()
	{
	   $status_tag = '';
	   switch ($this->status){
	      case static::INIT:$status_tag='订单已确认';break;
	      case static::CANCELED:$status_tag='订单已取消'; break;
	      case static::PAID:$status_tag='订单已支付'; break;
	      case static::REFUSED:$status_tag='订单退款'; break;
	      case static::DELIVERED:$status_tag='订单已发货'; break;
	      case static::DEALT:$status_tag='已确认收货/成交'; break;
	      case static::REJECTED:$status_tag='已拒绝收货';break;
	      case static::CLOSED:$status_tag='关闭'; break;
	      case static::COMPARE_BILL_FAIL:$status_tag='对账失败';break;
	      default: $status_tag='未知';
	   }   
	   return $status_tag;
	}
	
	public function deliver_status(){
	    $status_tag = '';
	    switch ($this->status){
	        case static::INIT:$status_tag='未付款';break;
	        case static::CANCELED:$status_tag='已取消'; break;
	        case static::PAID:$status_tag='未发货'; break;
	        case static::REFUSED:$status_tag='退款中'; break;
	        case static::DELIVERED:$status_tag='已发货'; break;
	        case static::DEALT:$status_tag='已收货'; break;
	        case static::REJECTED:$status_tag='已拒绝收货';break;
	        case static::CLOSED:$status_tag='关闭'; break;
	        case static::COMPARE_BILL_FAIL:$status_tag='对账失败';break;
	        default: $status_tag='未知';
	    }
	    return $status_tag;
	}
	
	public function users(){
	    return $this->hasOne('App\\User','id','uid');
	}
	
	public function details()
	{
		return $this->hasMany('App\\OrderDetail', 'oid', 'id')->with(['product']);
	}

	public function bills()
	{
		return $this->morphMany('App\\Bill', 'table');
	}
    //预计收益
	public function expect_money($uid)
	{
	    $money = 0;
	    $bills =  $this->bills()->get();
	    foreach ($bills as $bill){
	        ($bill->uid == $uid)&& $money+= $this->value;
	    }
	    return $money;
	}
	
	public function shop()
	{
		return $this->hasOne('App\\Shop', 'id', 'sid')->with(['user']);
	}

	public function order_express()
	{
		return $this->hasOne('App\\OrderExpress', 'id', 'id')->with(['express_types','express_type_names','shop','user_address']);
	}
	
	public function init($transaction = TRUE)
	{
		$transaction && DB::beginTransaction();
		$order = static::where($this->getKeyName(), $this->getKey())->lockForUpdate()->first();

		if ($order->status != static::UNKNOWN) //刚刚加入到数据库
		{
			$transaction && DB::rollback();
			return false;
		}
		
		$order->status = static::INIT;
		$order->save();
		$transaction && DB::commit();
		return true;
	}

	public function canceled($transaction = TRUE)
	{
		$transaction && DB::beginTransaction();
		$order = static::where($this->getKeyName(), $this->getKey())->lockForUpdate()->first();

		if ($order->status != static::INIT && $order->status != static::REFUSED) //初始状态或者是退款状态
		{
			$transaction && DB::rollback();
			return false;
		}
	
		$order->status = static::CANCELED;
		$order->save();
		$transaction && DB::commit();
		return true;
	}

	//支付
	public function pay($total_fee, $transaction = TRUE, $pay_type = Order::PAY_OFFLINE)
	{
		$transaction && DB::beginTransaction();
		$order = static::where($this->getKeyName(), $this->getKey())->lockForUpdate()->first();

		if ($order->status != static::INIT) //初始状态
		{
			$transaction && DB::rollback();
			return false;
		}

		//对账失败
		if (abs($total_fee - $order->total_money) >= 0.01 )
		{
			$order->status = static::COMPARE_BILL_FAIL;
			$order->save();
			$transaction && DB::commit();
			return false;
		}

		//用户已消费
		$order->bills()->create([
			'value' => -$order->total_money,
			'uid' => $order->uid,
			'event' => Bill::PURCHASE,
		]);
       
		$order->pay_type = $pay_type;
		$order->status = static::PAID;
		$order->save();

		$transaction && DB::commit();
		return true;
	}

	//快递
	public function express($express_name, $express_no, $transaction = TRUE)
	{
		$transaction && DB::beginTransaction();
		$order = static::where($this->getKeyName(), $this->getKey())->lockForUpdate()->first();

		if ($order->status != static::PAID) //未支付
		{
			$transaction && DB::rollback();
			return false;
		}

		$express = OrderExpress::where($this->getKeyName(), $this->getKey())->lockForUpdate()->first();
		$express->update([
			'express_name' => $express_name,
			'no' => $express_no,
		]);

		$order->status = static::DELIVERED;
		$order->save();
		$transaction && DB::commit();
		return true;
	}

	//确认收货
	public function deal($dealing = true, $transaction = TRUE)
	{
		$transaction && DB::beginTransaction();
		$order = static::where($this->getKeyName(), $this->getKey())->lockForUpdate()->first();

		if ($order->status != static::DELIVERED) //未发货
		{
			$transaction && DB::rollback();
			return false;
		}

		foreach($order->bills()->lockForUpdate()->get() as $stat)
		{
			if (!$stat->deal($dealing, false))
			{
				$transaction && DB::rollBack();
				return false;
			}
		}
		$order->status = static::DEALT;
		$order->save();
		$transaction && DB::commit();
		return true;
	}
}

Order::creating(function($order){
	$order->total_money = $order->details_money + $order->expresses_money;
});

Order::updating(function($order){	
	if ($order->isDirty('details_money') || $order->isDirty('expresses_money'))
	{
		if ($order->status != Order::INIT)
			return false;
		$order->total_money = $order->details_money + $order->expresses_money;
	}

});