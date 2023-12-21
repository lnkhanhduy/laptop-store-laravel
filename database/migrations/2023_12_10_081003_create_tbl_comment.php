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
        Schema::create('tbl_comment', function (Blueprint $table) {
            $table->bigIncrements('comment_id');
            $table->string('comment_content');
            $table->string('comment_reply');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('comment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_comment');
    }
};
