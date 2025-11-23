<?php

namespace App\Services;

use App\Models\ProjStage;
use App\Models\Userproj;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class EnrollmentBoardService
{
    public function buildBoard(Userproj $enrollment): array
    {
        $enrollment->loadMissing([
            'project',
            'projStages' => fn ($query) => $query->orderBy('order'),
        ]);

        $stages = $enrollment->projStages
            ->map(fn (ProjStage $stage) => $this->formatStage($stage))
            ->values();

        $columns = [
            ['id' => 'todo', 'name' => __('student.board.todo') ?? 'Do zrobienia', 'order' => 1, 'color' => '#64748b'],
            ['id' => 'in_progress', 'name' => __('student.board.in_progress') ?? 'W toku', 'order' => 2, 'color' => '#3b82f6'],
            ['id' => 'done', 'name' => __('student.board.done') ?? 'Zakończone', 'order' => 3, 'color' => '#10b981'],
        ];

        return [
            'columns' => $columns,
            'stages' => $stages,
            'activeStageId' => $enrollment->current_stage_id ?? ($stages->first()['id'] ?? null),
            'syncUrl' => route('student.enrollments.stages.sync', [
                'enrollment' => $enrollment->id,
                'stage' => '__STAGE__',
            ]),
            'csrfToken' => csrf_token(),
            'enrollment' => [
                'id' => $enrollment->id,
                'name' => $enrollment->name,
                'project' => $enrollment->project?->name,
                'status' => $enrollment->status,
                'status_cache' => $enrollment->status_cache ?? [],
            ],
        ];
    }

    public function syncStage(Userproj $enrollment, ProjStage $stage, array $tasksPayload): array
    {
        $incoming = Collection::make($tasksPayload)->keyBy('id');
        $now = now();

        $tasks = Collection::make($stage->tasks ?? [])
            ->map(function (array $task) use ($incoming, $now) {
                $taskId = (string) ($task['id'] ?? ($task['blueprint_task_id'] ?? ''));
                $update = $incoming->get($taskId);

                if ($update) {
                    $previousStatus = $task['status'] ?? 'todo';

                    $task['status'] = $update['status'];
                    $task['order'] = $update['order'];

                    if ($previousStatus !== $update['status']) {
                        $task['moved_at'] = $now->toIso8601String();
                    }
                }

                return $task;
            })
            ->sortBy('order')
            ->values();

        $stageStatusBefore = $stage->status;
        $stageCounts = $this->summarizeStageTasks($tasks);

        if ($stageCounts['total'] > 0 && $stageCounts['done'] === $stageCounts['total']) {
            $stage->status = ProjStage::STATUS_COMPLETED;
            $stage->completed_at ??= $now;
        } elseif ($stageCounts['in_progress'] > 0 || $stageCounts['done'] > 0) {
            $stage->status = ProjStage::STATUS_IN_PROGRESS;
            $stage->started_at ??= $now;
        } else {
            $stage->status = ProjStage::STATUS_PENDING;
        }

        $stage->tasks = $tasks->all();
        $stage->status_cache = [
            'tasks_total' => $stageCounts['total'],
            'tasks_done' => $stageCounts['done'],
            'tasks_in_progress' => $stageCounts['in_progress'],
            'progress' => $stageCounts['total'] ? (int) round(($stageCounts['done'] / $stageCounts['total']) * 100) : 0,
        ];
        $stage->save();

        $this->updateEnrollmentProgress($enrollment);

        $completedJustNow = $stageStatusBefore !== ProjStage::STATUS_COMPLETED
            && $stage->status === ProjStage::STATUS_COMPLETED;

        return [
            'stage' => [
                'id' => $stage->id,
                'status' => $stage->status,
                'status_cache' => $stage->status_cache,
                'started_at' => optional($stage->started_at)->toIso8601String(),
                'completed_at' => optional($stage->completed_at)->toIso8601String(),
            ],
            'enrollment' => [
                'id' => $enrollment->id,
                'status' => $enrollment->status,
                'current_stage_id' => $enrollment->current_stage_id,
                'status_cache' => $enrollment->status_cache,
            ],
            'message' => $completedJustNow
                ? __('student.notifications.stage_completed') ?? 'Etap ukończony. Świetna robota!'
                : null,
        ];
    }

    private function formatStage(ProjStage $stage): array
    {
        $tasks = Collection::make($stage->tasks ?? [])
            ->map(function (array $task, int $index) {
                $taskId = (string) ($task['id'] ?? ($task['blueprint_task_id'] ?? $index));

                return [
                    'id' => $taskId,
                    'title' => Arr::get($task, 'name', 'Zadanie'),
                    'description' => Arr::get($task, 'description', ''),
                    'status' => Arr::get($task, 'status', 'todo'),
                    'order' => Arr::get($task, 'order', $index),
                    'priority' => Arr::get($task, 'priority', 'medium'),
                    'timeEstimate' => Arr::get($task, 'planned_duration'),
                ];
            })
            ->sortBy('order')
            ->values();

        return [
            'id' => $stage->id,
            'name' => $stage->name,
            'description' => $stage->description,
            'order' => $stage->order,
            'status' => $stage->status,
            'started_at' => optional($stage->started_at)->toIso8601String(),
            'completed_at' => optional($stage->completed_at)->toIso8601String(),
            'status_cache' => $stage->status_cache ?? [
                'tasks_total' => $tasks->count(),
                'tasks_done' => 0,
                'tasks_in_progress' => 0,
                'progress' => 0,
            ],
            'tasks' => $tasks,
        ];
    }

    private function summarizeStageTasks(Collection $tasks): array
    {
        $total = $tasks->count();
        $done = $tasks->where('status', 'done')->count();
        $inProgress = $tasks->where('status', 'in_progress')->count();

        return [
            'total' => $total,
            'done' => $done,
            'in_progress' => $inProgress,
        ];
    }

    private function updateEnrollmentProgress(Userproj $enrollment): void
    {
        $stages = $enrollment->projStages()->orderBy('order')->get();
        $total = $stages->count();
        $completed = $stages->where('status', ProjStage::STATUS_COMPLETED)->count();
        $current = $stages->firstWhere(fn (ProjStage $stage) => $stage->status !== ProjStage::STATUS_COMPLETED);

        $enrollment->status_cache = [
            'stages_total' => $total,
            'stages_completed' => $completed,
            'current_stage_order' => $current?->order,
            'progress' => $total ? (int) round(($completed / $total) * 100) : 0,
        ];

        if ($current) {
            $enrollment->current_stage_id = $current->id;
        } else {
            $enrollment->current_stage_id = null;
            $enrollment->completed_at ??= now();
            $enrollment->status = 2;
        }

        $enrollment->save();
    }
}
