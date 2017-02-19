<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	public function up()
	{
		Schema::create('transactions', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
			$table->softDeletes();
			$table->timestamp('date')->index()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->float('value')->default('0');
			$table->text('description')->nullable();
			$table->string('title', 255)->nullable();
			$table->string('to', 255)->nullable();
			$table->string('from', 255)->nullable();
			$table->boolean('credit_card')->index()->default(1);
			$table->integer('transfert_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('transactions');
	}
}