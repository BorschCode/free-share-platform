<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ItemStatus; // Import the newly created Enum

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who created the item
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('city');
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable();
            $table->json('photos')->nullable(); // Store multiple photo paths

            // 1. New integer column for status
            $table->unsignedTinyInteger('status')
                ->default(ItemStatus::Available->value) // Use the Enum value as the default
                ->comment('1: Available, 2: Gifted'); // Add comment for DB management

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
