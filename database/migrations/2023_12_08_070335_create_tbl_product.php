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
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_name');
            $table->string('product_slug');
            $table->integer('category_product_id');
            $table->integer('brand_id');
            $table->integer('product_quantity');
            $table->integer('product_sold');
            $table->text('product_desc');
            $table->text('product_content');
            $table->string('product_cost');
            $table->string('product_price');
            $table->string('product_price_discount');
            $table->string('product_image');
            $table->integer('product_status');
            $table->bigInteger('product_views');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_product');
    }
};
