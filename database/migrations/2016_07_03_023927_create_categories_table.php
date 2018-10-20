<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->comment('ID pai');
            $table->integer('post_count')->default(0)->comment('Número de postagens');
            $table->tinyInteger('weight')->default(0)->comment('Peso');
            $table->string('name')->index()->comment('Nome');
            $table->string('slug', 60)->unique()->comment('Nome abreviado');
            $table->string('description')->nullable()->comment('Descrição');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }
}
