<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户表
        Schema::create('blog_admin', function (Blueprint $table) {
            $table->mediumIncrements('id')->primary()->unsigned()->nullable(false)->comment('帐号');
            $table->string('account',191)->nullable(false)->unique()->comment('密码');
            $table->string('password',254)->nullable(false)->comment('密码');
            $table->unsignedTinyInteger('status',false)->nullable(false)->default(1)->comment('0 - 禁用　1 - 启用');
            $table->string('email',191)->nullable(true)->unique()->comment('管理员邮箱');
            $table->string('tel',25)->nullable(true)->unique()->comment('电话号码');
            $table->dateTime('created_at')->nullable(true);
            $table->dateTime('updated_at')->nullable(true);
            $table->charset = 'utf8';
            $table->engine = 'innodb';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_admin');
    }
}
