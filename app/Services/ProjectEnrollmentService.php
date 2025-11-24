<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjStage;
use App\Models\Stage;
use App\Models\Task;
use App\Models\User;
use App\Models\Userproj;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProjectEnrollmentService
{
    private const TASK_STATUS_TODO = 'todo';

    public function enroll(User $student, Project $project, ?string $customName = null): Userproj
    {
        if ($this->hasEnrollment($student, $project)) {
            $message = __('student.validation.already_enrolled');

            if ($message === 'student.validation.already_enrolled') {
                $message = 'Masz już aktywny zapis w tym projekcie.';
            }

            throw ValidationException::withMessages([
                'project' => $message,
            ]);
        }

        return DB::transaction(function () use ($student, $project, $customName) {
            $now = now();

            $stages = $project->stages()
                ->with(['tasks' => fn($query) => $query->orderBy('order')])
                ->orderBy('order')
                ->get();

            /** @var Userproj $enrollment */
            $enrollment = Userproj::query()->create([
                'name' => $customName ?: $project->name,
                'description' => $project->description,
                'start_date' => $now,
                'status' => 1,
                'user_id' => $student->id,
                'project_id' => $project->id,
                'started_at' => $now,
            ]);

            $stageSnapshots = Collection::make();

            foreach ($stages as $stage) {
                $tasksPayload = $this->mapTasksPayload($stage);
                $stageSnapshots->push(
                    $enrollment->projStages()->create([
                        'name' => $stage->name,
                        'description' => $stage->description,
                        'order' => $stage->order,
                        'duration' => $stage->duration,
                        'active' => $stage->active,
                        'status' => ProjStage::STATUS_PENDING,
                        'status_cache' => $this->buildStageStatusCache($tasksPayload),
                        'tasks' => $tasksPayload,
                        'stage_id' => $stage->id,
                    ])
                );
            }

            $firstStage = $stageSnapshots->first();

            $enrollment->forceFill([
                'current_stage_id' => $firstStage?->id,
                'status_cache' => $this->buildEnrollmentStatusCache(
                    $stageSnapshots->count(),
                    $firstStage?->order
                ),
            ])->save();

            return $enrollment->fresh('projStages');
        });
    }

    public function hasEnrollment(User $student, Project $project): bool
    {
        return Userproj::query()
            ->where('user_id', $student->id)
            ->where('project_id', $project->id)
            ->exists();
    }

    private function mapTasksPayload(Stage $stage): array
    {
        return $stage->tasks
            ->sortBy('order')
            ->map(fn(Task $task) => [
                'id' => (string) Str::uuid(),
                'blueprint_task_id' => $task->id,
                'name' => $task->name,
                'description' => $task->description,
                'order' => $task->order,
                'planned_duration' => $task->duration,
                'status' => self::TASK_STATUS_TODO,
                'assignee_id' => null,
                'moved_at' => null,
            ])
            ->values()
            ->all();
    }

    private function buildStageStatusCache(array $tasksPayload): array
    {
        return [
            'tasks_total' => count($tasksPayload),
            'tasks_done' => 0,
            'tasks_in_progress' => 0,
            'progress' => 0,
        ];
    }

    private function buildEnrollmentStatusCache(int $stageCount, ?int $currentStageOrder = null): array
    {
        return [
            'stages_total' => $stageCount,
            'stages_completed' => 0,
            'current_stage_order' => $currentStageOrder,
            'progress' => 0,
        ];
    }
}
