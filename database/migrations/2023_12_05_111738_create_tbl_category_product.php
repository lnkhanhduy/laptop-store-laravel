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
        Schema::create('tbl_category_product', function (Blueprint $table) {
            $table->increments('category_product_id');
            $table->string('category_product_name');
            $table->string('category_product_slug');
            $table->integer('category_product_parent');
            $table->integer('category_product_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_category_product');
    }
};
