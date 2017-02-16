<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransfertsTable extends Migration {

	public function up()
	{
		Schema::create('transferts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
			$table->softDeletes();
			$table->float('value')->default('0');
			$table->string('from', 255)->nullable();
			$table->string('to')->nullable();
			$table->smallInteger('day')->default('1');
			$table->string('title', 255)->nullable();
			$table->text('description')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('transferts');
	}
}