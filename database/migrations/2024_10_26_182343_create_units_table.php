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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->integer('category_id');
            $table->string('city_id');
            $table->integer('product_id');
            $table->string('code')->nullable();
            $table->string('qty')->nullable();
            $table->string('size')->nullable();
            $table->integer('price')->nullable();
            $table->string('discount_price')->nullable();
            $table->string('image')->nullable();
            $table->string('client_id')->nullable();
            $table->string('most_popular')->nullable();
            $table->string('best_seller')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
