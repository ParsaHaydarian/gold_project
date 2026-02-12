<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('title');
            $table->string('link')->nullable();

            $table->string('image_1'); // Profile Image
            $table->string('image_2')->nullable(); // Story Image (nullable if type is video)
            $table->string('video')->nullable();   // Video file (nullable if type is image)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
