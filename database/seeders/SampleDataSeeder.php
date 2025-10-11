<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Project;
use App\Models\Stage;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    /**
     * Seed illustrative data for teachers, students, groups, and sample projects.
     */
    public function run(): void
    {
        $teacherGroup = Group::updateOrCreate(
            ['name' => 'Teacher Cohort'],
            ['description' => 'Faculty members collaborating on shared curricula.'],
        );

        $studentGroups = collect([
            [
                'name' => 'Applied Informatics 2025',
                'description' => 'Fourth-term students focusing on web applications.',
            ],
            [
                'name' => 'Data Science 2025',
                'description' => 'Student team exploring machine learning projects.',
            ],
        ])->map(function (array $group) {
            return Group::updateOrCreate(
                ['name' => $group['name']],
                ['description' => $group['description']],
            );
        });

        $teachers = collect([
            [
                'name' => 'Alicja Hart',
                'email' => 'alicia.hart@example.com',
            ],
            [
                'name' => 'Marek Zieliński',
                'email' => 'marek.zielinski@example.com',
            ],
        ])->map(function (array $teacher) {
            return User::updateOrCreate(
                ['email' => $teacher['email']],
                [
                    'name' => $teacher['name'],
                    'role' => 1,
                    'active' => true,
                    'password' => Hash::make('password'),
                ],
            );
        });

        $students = collect([
            [
                'name' => 'Magda Krawczyk',
                'email' => 'magda.krawczyk@example.com',
                'group' => 'Applied Informatics 2025',
            ],
            [
                'name' => 'Oskar Nowak',
                'email' => 'oskar.nowak@example.com',
                'group' => 'Applied Informatics 2025',
            ],
            [
                'name' => 'Julia Konieczna',
                'email' => 'julia.konieczna@example.com',
                'group' => 'Data Science 2025',
            ],
            [
                'name' => 'Paweł Wiśniewski',
                'email' => 'pawel.wisniewski@example.com',
                'group' => 'Data Science 2025',
            ],
        ])->map(function (array $student) {
            return [
                'model' => User::updateOrCreate(
                    ['email' => $student['email']],
                    [
                        'name' => $student['name'],
                        'role' => 0,
                        'active' => true,
                        'password' => Hash::make('password'),
                    ],
                ),
                'group' => $student['group'],
            ];
        });

        $teacherGroup->users()->syncWithoutDetaching($teachers->pluck('id'));

        // Attach existing default teacher to the teacher group if present.
        $defaultTeacher = User::where('email', 'teacher@example.com')->first();
        if ($defaultTeacher) {
            $teacherGroup->users()->syncWithoutDetaching([$defaultTeacher->id]);
        }

        $students->each(function (array $student) use ($studentGroups) {
            $group = $studentGroups->firstWhere('name', $student['group']);

            if ($group) {
                $group->users()->syncWithoutDetaching([$student['model']->id]);
            }
        });

        $projectDefinitions = [
            [
                'name' => 'Scrum Board Revamp',
                'description' => 'Redesign the Scrum board to support swimlanes and card tagging.',
                'leadTime' => 28,
                'owner' => 'alicia.hart@example.com',
                'stages' => [
                    [
                        'name' => 'Discovery',
                        'description' => 'Understand expectations and current workflow gaps.',
                        'duration' => 7,
                        'tasks' => [
                            ['name' => 'Audit existing board usage', 'duration' => 2],
                            ['name' => 'Interview student teams', 'duration' => 3],
                            ['name' => 'Summarise pain points', 'duration' => 2],
                        ],
                    ],
                    [
                        'name' => 'Prototype',
                        'description' => 'Design and validate the improved Scrum experience.',
                        'duration' => 10,
                        'tasks' => [
                            ['name' => 'Create wireframes', 'duration' => 4],
                            ['name' => 'Validate with teachers', 'duration' => 2],
                            ['name' => 'Adjust UI interactions', 'duration' => 4],
                        ],
                    ],
                    [
                        'name' => 'Rollout',
                        'description' => 'Roll out the new board and gather feedback.',
                        'duration' => 11,
                        'tasks' => [
                            ['name' => 'Create training materials', 'duration' => 3],
                            ['name' => 'Pilot with Applied Informatics group', 'duration' => 4],
                            ['name' => 'Collect feedback & iterate', 'duration' => 4],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Machine Learning Bootcamp',
                'description' => 'Prepare a four-week ML bootcamp using Kaggle datasets.',
                'leadTime' => 24,
                'owner' => 'marek.zielinski@example.com',
                'stages' => [
                    [
                        'name' => 'Curriculum design',
                        'description' => 'Plan the structure and outcomes of the bootcamp.',
                        'duration' => 6,
                        'tasks' => [
                            ['name' => 'Select target competencies', 'duration' => 2],
                            ['name' => 'Choose datasets', 'duration' => 2],
                            ['name' => 'Draft project briefs', 'duration' => 2],
                        ],
                    ],
                    [
                        'name' => 'Content production',
                        'description' => 'Prepare teaching assets for the bootcamp.',
                        'duration' => 10,
                        'tasks' => [
                            ['name' => 'Build notebook templates', 'duration' => 3],
                            ['name' => 'Record theory videos', 'duration' => 4],
                            ['name' => 'Prepare grading rubric', 'duration' => 3],
                        ],
                    ],
                    [
                        'name' => 'Pilot & feedback',
                        'description' => 'Test materials with students and refine content.',
                        'duration' => 8,
                        'tasks' => [
                            ['name' => 'Run pilot workshop', 'duration' => 3],
                            ['name' => 'Survey Data Science students', 'duration' => 2],
                            ['name' => 'Final adjustments', 'duration' => 3],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Capstone Mentoring Toolkit',
                'description' => 'Shared resources for supervising final projects.',
                'leadTime' => 18,
                'owner' => 'teacher@example.com',
                'stages' => [
                    [
                        'name' => 'Resource audit',
                        'description' => 'Review available mentoring resources.',
                        'duration' => 5,
                        'tasks' => [
                            ['name' => 'Collect existing templates', 'duration' => 2],
                            ['name' => 'Identify missing artefacts', 'duration' => 3],
                        ],
                    ],
                    [
                        'name' => 'Toolkit compilation',
                        'description' => 'Assemble a cohesive package for mentors.',
                        'duration' => 7,
                        'tasks' => [
                            ['name' => 'Draft mentoring checklist', 'duration' => 3],
                            ['name' => 'Prepare feedback forms', 'duration' => 2],
                            ['name' => 'Compile knowledge base', 'duration' => 2],
                        ],
                    ],
                    [
                        'name' => 'Launch',
                        'description' => 'Release the toolkit and gather feedback.',
                        'duration' => 6,
                        'tasks' => [
                            ['name' => 'Introduce toolkit to teachers', 'duration' => 2],
                            ['name' => 'Collect improvement suggestions', 'duration' => 2],
                            ['name' => 'Publish final version', 'duration' => 2],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($projectDefinitions as $definition) {
            $owner = User::where('email', $definition['owner'])->first();

            if (! $owner) {
                continue;
            }

            $project = Project::updateOrCreate(
                [
                    'name' => $definition['name'],
                    'user_id' => $owner->id,
                ],
                [
                    'description' => $definition['description'],
                    'leadTime' => $definition['leadTime'],
                    'active' => true,
                ],
            );

            $project->stages()->delete();

            $stageOrder = 1;
            foreach ($definition['stages'] as $stageData) {
                $stage = Stage::create([
                    'project_id' => $project->id,
                    'name' => $stageData['name'],
                    'description' => $stageData['description'] ?? null,
                    'order' => $stageOrder++,
                    'duration' => $stageData['duration'],
                    'active' => true,
                ]);

                $taskOrder = 1;
                foreach ($stageData['tasks'] as $taskData) {
                    Task::create([
                        'stage_id' => $stage->id,
                        'name' => $taskData['name'],
                        'description' => $taskData['description'] ?? $taskData['name'],
                        'order' => $taskOrder++,
                        'duration' => $taskData['duration'],
                        'active' => true,
                    ]);
                }
            }
        }
    }
}
