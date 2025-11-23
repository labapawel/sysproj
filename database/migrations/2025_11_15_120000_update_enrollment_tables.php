<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('userprojs', function (Blueprint $table) {
            $table->foreignId('current_stage_id')
                ->nullable()
                ->after('project_id')
                ->constrained('proj_stages')
                ->nullOnDelete();
            $table->timestamp('started_at')->nullable()->after('current_stage_id');
            $table->timestamp('completed_at')->nullable()->after('started_at');
            $table->boolean('is_overdue')->default(false)->after('completed_at');
            $table->json('status_cache')->nullable()->after('is_overdue');

            $table->unique(['user_id', 'project_id']);
        });

        Schema::table('proj_stages', function (Blueprint $table) {
            $table->string('status', 24)->default('pending')->after('stage_id');
            $table->timestamp('started_at')->nullable()->after('status');
            $table->timestamp('completed_at')->nullable()->after('started_at');
            $table->boolean('is_overdue')->default(false)->after('completed_at');
            $table->json('status_cache')->nullable()->after('is_overdue');
        });

        Schema::dropIfExists('workers');
    }

    public function down(): void
    {
        Schema::table('userprojs', function (Blueprint $table) {
            $table->dropUnique('userprojs_user_id_project_id_unique');
            $table->dropForeign(['current_stage_id']);
            $table->dropColumn([
                'current_stage_id',
                'started_at',
                'completed_at',
                'is_overdue',
                'status_cache',
            ]);
        });

        Schema::table('proj_stages', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'started_at',
                'completed_at',
                'is_overdue',
                'status_cache',
            ]);
        });

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
};
