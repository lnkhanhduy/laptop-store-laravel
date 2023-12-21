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
        Schema::create('tbl_order', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->integer('user_id');
            $table->string('order_code');
            $table->string('order_name');
            $table->string('order_address');
            $table->string('order_email');
            $table->string('order_phone');
            $table->text('order_note');
            $table->integer('order_payment_method');
            $table->integer('voucher_id');
            $table->string('order_total');
            $table->integer('order_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_order');
    }
};
