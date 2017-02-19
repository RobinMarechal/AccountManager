<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('transactions', function(Blueprint $table) {
			$table->foreign('transfert_id')->references('id')->on('transferts')
						->onDelete('set null')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('transactions', function(Blueprint $table) {
			$table->dropForeign('transactions_transfert_id_foreign');
		});
	}
}