<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\AsCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

#[AsCommand(name: 'app:create-user')]
class CreateUser extends Command
{
    protected $description = 'Create a new user with the provided credentials and roles.';

    protected $signature = <<<'SIG'
        app:create-user
            {name? : Display name for the user}
            {email? : Unique email address}
            {password? : Plain-text password (will be hashed)}
            {--role=* : Role(s) to assign (student, teacher, admin)}
            {--inactive : Create the user as inactive}
    SIG;

    public function handle(): int
    {
        $name = $this->argument('name') ?? $this->promptUntilFilled('Name');
        $email = $this->argument('email') ?? $this->promptUntilFilled('Email address');
        $password = $this->argument('password') ?? $this->promptUntilFilled('Password', secret: true);

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('The provided email is not valid.');

            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error("A user with email {$email} already exists.");

            return self::FAILURE;
        }

        $rolesInput = Arr::wrap($this->option('role'));

        if (empty(array_filter($rolesInput))) {
            $rolesInput = $this->choice(
                'Select role(s) for the user',
                choices: ['student', 'teacher', 'admin'],
                default: 'student',
                multiple: true
            );
        }

        $roleValue = $this->resolveRoleValue($rolesInput);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $roleValue,
            'active' => ! $this->option('inactive'),
        ]);

        $roleLabels = $user->role_labels;
        if (empty($roleLabels)) {
            $roleLabels = [__('admin.title.roles.user')];
        }

        $this->table(
            ['ID', 'Name', 'Email', 'Roles', 'Active'],
            [[
                $user->id,
                $user->name,
                $user->email,
                implode(', ', $roleLabels),
                $user->active ? 'yes' : 'no',
            ]]
        );

        $this->info('User created successfully.');

        return self::SUCCESS;
    }

    protected function resolveRoleValue(array $roles): int
    {
        $roles = array_map(fn ($role) => strtolower(trim((string) $role)), $roles);
        $roles = array_filter($roles);

        $map = [
            'student' => 0,
            'user' => 0,
            'teacher' => 1,
            'moderator' => 1,
            'guardian' => 1,
            'admin' => 2,
        ];

        $value = 0;

        foreach ($roles as $role) {
            if (! array_key_exists($role, $map)) {
                $this->warn("Unknown role '{$role}' ignored.");

                continue;
            }

            $value |= $map[$role];
        }

        return $value;
    }

    protected function promptUntilFilled(string $question, bool $secret = false): string
    {
        do {
            $answer = $secret ? $this->secret($question) : $this->ask($question);
        } while (blank($answer));

        return $answer;
    }
}
