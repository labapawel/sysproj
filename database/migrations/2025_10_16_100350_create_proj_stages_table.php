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
        Schema::create('proj_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order')->default(0); // Order of the stage in the project
            $table->integer('duration')->nullable(); // Duration in procented project time
            $table->boolean('active')->default(true); // active
            $table->json("settings")->nullable(); // settings for the stage
            $table->json("tasks")->nullable(); // notifications for the stage
            $table->foreignId('userproj_id')->constrained()->onDelete('cascade');
            $table->foreignId('stage_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proj_stages');
    }
};
