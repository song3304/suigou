<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePayTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
	    Schema::create('user_addresses', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('realname',50)->comment = '姓名'; //省
	        $table->string('phone',50)->nullable()->index()->comment = '电话'; //省
	        $table->unsignedInteger('province')->comment = '省'; //省
	        $table->unsignedInteger('city')->comment = '市'; //市
	        $table->unsignedInteger('area')->comment = '区县'; //区县
	        $table->string('address', 250)->comment = '地址';
	        $table->string('postal_code', 50)->nullable()->comment = '邮编';
	        $table->unsignedInteger('uid')->comment = '用户UID';
	        $table->timestamp('used_at')->nullable()->comment = '最后使用时间';
	        $table->timestamps();
	        $table->softDeletes(); //软删除
	        $table->foreign('uid')->references('id')->on('users')
	        ->onUpdate('cascade')->onDelete('cascade');
	    });
	    
	    Schema::create('orders', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('title', 250)->comment = '标题';
	        $table->decimal('total_money', 16, 2)->index()->comment = '总金额';
	        $table->decimal('details_money', 16, 2)->index()->comment = '详情金额';
	        $table->decimal('expresses_money', 16, 2)->comment = '快递金额';
	        $table->tinyInteger('status')->index()->comment = '订单状态';
	        $table->unsignedInteger('sid')->default(0)->index()->comment = '门店ID';
	        $table->unsignedInteger('uid')->index()->comment = '用户UID';
	        $table->timestamps();
	        $table->softDeletes(); //软删除
	        $table->foreign('uid')->references('id')->on('users')
	            ->onUpdate('cascade')->onDelete('cascade');
	    });
	    
	    Schema::create('order_expresses', function (Blueprint $table) {
	        $table->unsignedInteger('id')->uniqid();
	        $table->unsignedInteger('express_type')->default(0)->comment = '快递类型';
	        $table->unsignedInteger('uaid')->default(0)->comment = '用户地址';
	        $table->unsignedInteger('sid')->default(0)->comment = '门店ID';
	        $table->unsignedInteger('express_name')->comment = '快递名称';
	        $table->string('no', 100)->nullable()->comment = '快递单号';
	        $table->timestamps();
	                	
	        $table->foreign('id')->references('id')->on('orders')
	                ->onUpdate('cascade')->onDelete('cascade');
	     });
	    
	    Schema::create('order_details', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedInteger('oid')->default(0); //Orders ID
	        $table->unsignedInteger('pid')->default(0); //Products ID
	        $table->decimal('unit_price', 16, 2)->comment = '单价'; //钱
	        $table->unsignedInteger('count')->default(0)->comment = '数量'; //数量
	        $table->string('note', 250)->comment = '特殊说明';
	        $table->string('attrs_tag',250)->nullable()->comment="属性说明";
	        $table->timestamps();
	                    	
	        $table->foreign('oid')->references('id')->on('orders')
	         ->onUpdate('cascade')->onDelete('cascade');
	        $table->foreign('pid')->references('id')->on('products')
	         ->onUpdate('cascade')->onDelete('cascade');
	    });
	    
	    Schema::create('bills', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('title', 250)->nullable()->comment = '流水账标题';
	        $table->decimal('value', 16, 2)->default(0)->comment = '流水金额';
	        $table->tinyInteger('is_dealt')->default(0)->comment = '已成交';
	        $table->string('event', 150)->index()->comment = '事件名' ;
	        $table->unsignedInteger('uid')->index()->comment = '事件关系到的用户UID';
	        $table->unsignedInteger('table_id')->index()->comment = '多态关联ID';
	        $table->string('table_type', 125)->index()->comment = '多态关联TYPE';
	        $table->timestamps();
	        $table->softDeletes(); //软删除
	    
	        $table->foreign('uid')->references('id')->on('users')
	         ->onUpdate('cascade')->onDelete('cascade');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
	    Schema::drop('bills');
	    Schema::drop('order_details');
	    Schema::drop('order_expresses');
	    Schema::drop('orders');
	    Schema::drop('user_addresses');
	}
}
