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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->timestamp('starttime')->nullable();
            $table->timestamp('endtime')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'paused'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
