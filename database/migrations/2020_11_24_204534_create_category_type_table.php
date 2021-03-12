<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_type', function (Blueprint $table) {
            $table->id();
			$table->foreignId('category_id')->nullable()
				  ->constrained()
	      		  ->onDelete('set null')
	      		  ->onUpdate('cascade');

			$table->foreignId('type_id')->nullable()
				  ->constrained()
				  ->onDelete('set null')
				  ->onUpdate('cascade');

			// $table->foreign('type_id')->references('id')->on('roles');
			// $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_type');
    }
}
