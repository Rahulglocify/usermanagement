<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); 
            $table->integer('user_id')->nullable();
            $table->string("name")->nullable();
            $table->float("price")->default(0);
            $table->longText("description")->nullable();
            $table->string("image")->nullable();
            $table->integer("quantity")->nullable();
            $table->tinyInteger("status")->default(0)->comment("0=>pending,1=>approved");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
