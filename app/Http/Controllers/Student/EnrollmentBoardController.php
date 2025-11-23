<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ProjStage;
use App\Models\Userproj;
use App\Services\EnrollmentBoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentBoardController extends Controller
{
    public function __construct(private readonly EnrollmentBoardService $service)
    {
    }

    public function sync(Request $request, Userproj $enrollment, ProjStage $stage): JsonResponse
    {
        $this->ensureOwnership($enrollment);
        abort_unless($stage->userproj_id === $enrollment->id, 404);

        $validated = $request->validate([
            'tasks' => ['required', 'array'],
            'tasks.*.id' => ['required', 'string'],
            'tasks.*.status' => ['required', 'in:todo,in_progress,done'],
            'tasks.*.order' => ['required', 'integer'],
        ]);

        $payload = $this->service->syncStage($enrollment, $stage, $validated['tasks']);

        return response()->json($payload);
    }

    private function ensureOwnership(Userproj $enrollment): void
    {
        $user = Auth::user();
        abort_if(! $user || $enrollment->user_id !== $user->id, 403);
    }
}
