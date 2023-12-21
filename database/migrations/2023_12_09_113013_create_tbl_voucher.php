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
        Schema::create('tbl_voucher', function (Blueprint $table) {
            $table->increments('voucher_id');
            $table->string('voucher_name');
            $table->string('voucher_code');
            $table->integer('voucher_type');
            $table->string('voucher_discount_amount');
            $table->integer('voucher_quantity');
            $table->integer('voucher_used');
            $table->string('voucher_used_by_user');
            $table->integer('voucher_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_voucher');
    }
};
