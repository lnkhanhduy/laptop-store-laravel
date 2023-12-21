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
        Schema::create('tbl_statistical', function (Blueprint $table) {
            $table->bigIncrements('statistical_id');
            $table->string('statistical_date');
            $table->string('statistical_sales');
            $table->string('statistical_profit');
            $table->integer('statistical_quantity');
            $table->integer('statistical_total_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_statistical');
    }
};
