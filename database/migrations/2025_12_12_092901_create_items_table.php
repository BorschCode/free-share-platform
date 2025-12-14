<?php

use App\Enums\ItemStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema; // Import the newly created Enum

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('city');
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable();
            $table->json('photos')->nullable();

            $table->unsignedTinyInteger('status')
                ->default(ItemStatus::Available->value)
                ->comment('1: Available, 2: Gifted');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
