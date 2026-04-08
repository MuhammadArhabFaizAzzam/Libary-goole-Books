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
        Schema::create('books', function (Blueprint $table) {
$table->id();
            $table->string('google_id')->unique()->nullable();
            $table->string('title');
            $table->json('authors')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('page_count')->nullable();
            $table->string('isbn_13')->nullable();
            $table->string('publisher')->nullable();
            $table->year('published_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
