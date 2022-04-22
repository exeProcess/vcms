<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoredProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stored_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("store");
            $table->string("name");
            $table->string("quantity");
            $table->timestamps();

            $table->foreign("store")->references('id')->on("storages")->ondelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stored_products');
    }
}
