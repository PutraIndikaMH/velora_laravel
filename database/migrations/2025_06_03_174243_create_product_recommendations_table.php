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
             // Gunakan HANYA SATU kali
            $table->foreignId('history_id')
                  ->constrained('histories')
                  ->onDelete('cascade');

            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            $table->timestamps();

            // Optional: Mencegah duplikasi entri
            $table->unique(['history_id', 'product_id']);
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