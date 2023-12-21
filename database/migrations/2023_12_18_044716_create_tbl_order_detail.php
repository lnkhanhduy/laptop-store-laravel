<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_order_detail', function (Blueprint $table) {
            $table->bigIncrements('order_detail_id');
            $table->bigInteger('order_id');
            $table->integer('product_id');
            $table->integer('product_quantity');
            $table->string('product_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_order_detail');
    }
};
