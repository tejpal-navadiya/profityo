<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emp_pay_category', function (Blueprint $table) {
            $table->integer('pay_cat_id')->unique()->primary();
            $table->integer('p_menu_id')->nullable()->default('0');
            $table->string('p_menu_title')->nullable();
            $table->text('p_menu_description')->nullable();
            $table->tinyInteger('p_menu_status')->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_pay_category');
    }
};
