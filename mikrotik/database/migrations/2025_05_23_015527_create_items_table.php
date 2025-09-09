<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->string('category');
            $table->string('location')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('supplier')->nullable();
            $table->enum('status', ['available', 'low_stock', 'out_of_stock'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};