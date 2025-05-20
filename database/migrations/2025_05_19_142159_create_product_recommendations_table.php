<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('history_id')->constrained()->onDelete('cascade');
            $table->string('product_category');
            $table->text('product_description')->nullable();
            $table->timestamp('recommendation_timestamp')->nullable();
            $table->string('recommendation_links')->nullable();
            $table->decimal('product_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_recommendations');
    }
};