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
        Schema::create('emp_deduction_tax', function (Blueprint $table) {
            $table->integer('de_cat_id')->unique()->primary();
            $table->integer('de_menu_id')->nullable()->default('0');
            $table->string('de_menu_title')->nullable();
            $table->text('de_menu_description')->nullable();
            $table->tinyInteger('de_menu_status')->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_deduction_tax');
    }
};
