<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0); // Order of the stage in the project
            $table->integer('duration')->nullable(); // Duration in procented project time
            $table->boolean('active')->default(true); // active, completed, on-hold
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
