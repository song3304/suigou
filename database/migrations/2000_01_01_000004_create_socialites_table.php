<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSocialitesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		// 第三方登录用户
		Schema::create('socialite_users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('plat_id',64)->comment = '用户ID';
			$table->string('username',50)->nullable()->comment = '预留电话';
			$table->string('nick_name',50)->nullable()->comment = '户名';
			$table->string('email',50)->nullable()->comment = '住址信息';
			$table->unsignedInteger('avatar_aid')->default(0)->comment = '头像AID'; //头像	
			$table->tinyInteger('login_type')->default(0)->index()->comment = '支付方式，0,QQ登录 ，1.微信登录';
			$table->integer('user_id')->unsigned()->unique()->comment = '用户ID';
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
		Schema::drop('socialite_users');
	}
}
