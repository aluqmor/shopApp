<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('product');
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->boolean('isSold')->default(false);
        $table->binary('img')->nullable(); // Miniatura como binario
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};