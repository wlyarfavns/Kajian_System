<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kajians', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organizer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mosque_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('speaker_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->text('address');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->enum('audience', ['umum', 'ikhwan', 'akhwat'])->default('umum');
            $table->boolean('is_family_friendly')->default(false);
            $table->boolean('is_free')->default(true);
            $table->integer('price')->default(0);
            $table->integer('quota')->nullable();
            $table->enum('status', ['draft', 'published', 'ongoing', 'finished', 'cancelled'])->default('draft');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('kajians');
    }
};
