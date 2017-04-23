<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfflineShopTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
	    //门店
	    Schema::create('shops', function (Blueprint $table) {
	        $table->unsignedInteger('id')->index;
	        $table->string('name',250)->comment='门店名称';
	        $table->unsignedInteger('province')->comment = '省'; //省
	        $table->unsignedInteger('city')->comment = '市'; //市
	        $table->unsignedInteger('area')->comment = '区县'; //区县
	        $table->string('address', 250)->comment = '地址';
	        $table->string('phone', 20)->nullable()->index()->comment = '电话'; //电话
	        $table->decimal('longitude', 16, 10)->comment='经度'; //经度
	        $table->decimal('latitude', 16, 10)->comment='纬度'; //纬度
	        $table->softDeletes(); //软删除
	    
	        $table->foreign('id')->references('id')->on('users')
				->onUpdate('cascade')->onDelete('cascade');
	        $table->timestamps();
	    });
	    //门店用户
	    Schema::create('shop_users', function (Blueprint $table) {
	        $table->increments('id');
			$table->integer('sid')->unsigned()->index()->comment = '门店ID';
			$table->integer('uid')->unsigned()->index()->comment = '用户ID';
			$table->timestamps();
	    });
	    //购物车
	    Schema::create('carts', function (Blueprint $table) {
	        $table->increments('id')->comment='主键';
	        $table->integer('uid')->unsigned()->index()->comment = '用户ID';
	        $table->unsignedInteger('pid')->default(0)->comment='商品id'; 
	        $table->unsignedInteger('buy_cnt')->comment = '购买数量'; //省
	        $table->string('attrs', 250)->comment = '产品属性{key:value}';
	        $table->string('note', 250)->comment = '特殊说明';
	        $table->softDeletes(); //软删除
	             
	        $table->foreign('uid')->references('id')->on('users')
	           ->onUpdate('cascade')->onDelete('cascade');
	        $table->foreign('pid')->references('id')->on('products')
	           ->onUpdate('cascade')->onDelete('cascade');
	        
	        $table->timestamps();
	    });
	    //导航表
	    Schema::create('navigations', function (Blueprint $table) {
	        $table->increments('id')->comment='主键';
	        $table->string('name', 100)->comment='栏目名';
	        $table->integer('sid')->unsigned()->index()->comment = '门店ID';
	        $table->integer('porder')->unsigned()->index()->comment = '排序';
	        $table->timestamps();
	        $table->softDeletes(); //软删除
	    });
	    //导航商品对应关系表
	    Schema::create('shop_products', function (Blueprint $table) {
	         $table->increments('id');
	         $table->integer('sid')->unsigned()->index()->comment = '门店ID';
	         $table->integer('pid')->unsigned()->index()->comment = '用户ID';
	         $table->integer('porder')->unsigned()->index()->comment = '排序';
	         $table->timestamps();
	    });
	    //商品主表
	    Schema::create('products', function (Blueprint $table) {
	        $table->increments('id')->comment='主键';
	        $table->unsignedInteger('sid')->default(0)->comment='门店id'; //
	        $table->string('title', 250)->comment='商品名称';
	        $table->string('keywords', 250)->comment='SEO关键字';
	        $table->string('description', 250)->comment='SEO描述';
	        $table->text('content')->comment='商品介绍';
	        $table->decimal('express_price', 16, 2)->comment='快递费/件';
	        $table->decimal('market_price', 16, 2)->comment='市场价格'; //价格
	        $table->decimal('price', 16, 2)->comment='优惠价格'; //价格
	        $table->unsignedInteger('count')->default(0)->comment='数量'; //数量
	        $table->softDeletes(); //软删除
	        	
	        $table->foreign('sid')->references('id')->on('users')
	        ->onUpdate('cascade')->onDelete('cascade');
	        $table->timestamps();
	    });
	    //封面图
	    Schema::create('product_covers', function (Blueprint $table) {
	        $table->increments('id')->comment='主键';
	        $table->unsignedInteger('pid')->default(0)->comment='商品id'; //Products ID
	        $table->unsignedInteger('cover_aid')->default(0)->comment='附件id'; //封面AID
	        	
	        $table->foreign('pid')->references('id')->on('products')
	        ->onUpdate('cascade')->onDelete('cascade');
	    
	        $table->timestamps();
	    });
	    //属性规格
	    Schema::create('product_attr_types', function (Blueprint $table) {
	        $table->increments('id')->comment='主键';
	        $table->unsignedInteger('pid')->default(0)->comment='商品id'; //Products ID
	        $table->string('name',25)->comment='属性规模名'; //属性分类名
	        $table->softDeletes(); //软删除
	         
	        $table->foreign('pid')->references('id')->on('products')
	        ->onUpdate('cascade')->onDelete('cascade');
	         
	        $table->timestamps();
	    });
	    //属性详情
	    Schema::create('product_attrs', function (Blueprint $table) {
	        $table->increments('id')->comment='主键';
	        $table->unsignedInteger('tid')->default(0)->comment='商品属性规格id'; //Products ID
	        $table->string('name',25)->comment='属性名'; //封面AID
	        $table->softDeletes(); //软删除
	         
	        $table->foreign('tid')->references('id')->on('product_attr_types')
	        ->onUpdate('cascade')->onDelete('cascade');
	         
	        $table->timestamps();
	    });
	    //评论表
	    Schema::create('reviews', function (Blueprint $table) {
	        $table->increments("id")->comment='主键';
	        $table->unsignedInteger("user_id")->index()->comment = "用户ID";
	        $table->unsignedInteger("product_id")->index()->comment = "商品ID";
	        $table->string("content",'250')->comment = "评论类容";
	        $table->unsignedInteger("pid")->default(0)->comment = "回复用户ID";
	        $table->unsignedInteger('order')->default(0)->index()->comment = 'TREE排序';
	        $table->unsignedInteger('level')->default(0)->index()->comment = 'TREE等级';
	        $table->string('path', '250')->index()->comment = 'TREE路径';
	        $table->timestamps();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
	    Schema::drop('shops');
	    Schema::drop('shop_users');
	    Schema::drop('carts');
	    Schema::drop('navigations');
	    Schema::drop('shop_products');
	    Schema::drop('products');
	    Schema::drop('product_covers');
	    Schema::drop('product_attr_types');
	    Schema::drop('product_attrs');
	    Schema::drop('reviews');
	}
}
