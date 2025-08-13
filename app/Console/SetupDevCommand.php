<?php

declare(strict_types=1);

namespace App\Console;

use App\Models\User;
use Gillyware\Gatekeeper\Enums\GatekeeperPermission;
use Gillyware\Gatekeeper\Facades\Gatekeeper;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

final class SetupDevCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'momtrax:setup 
        {--fresh : Drop all tables and re-run all migrations}';

    protected $description = 'Set up the MomTrax development environment.';

    public function handle(Filesystem $files): int
    {
        // Ensure .env exists
        $envPath = base_path('.env');
        if (! $files->exists($envPath)) {
            $this->info('Creating .env from .env.example …');
            $files->copy(base_path('.env.example'), $envPath);
        }

        // Generate app key.
        $this->call('key:generate', ['--ansi' => true]);

        // Ensure database file exists.
        $dbFile = database_path('database.sqlite');
        if (config('database.default') === 'sqlite' && ! $files->exists($dbFile)) {
            $this->info('Creating SQLite database file …');
            $files->put($dbFile, '');
        }

        // Run migrations.
        $this->info($this->option('fresh') ? 'Running migrate:fresh …' : 'Running migrations …');
        $this->call($this->option('fresh') ? 'migrate:fresh' : 'migrate', ['--ansi' => true]);

        // Seed database.
        $this->call('db:seed', ['--ansi' => true]);

        // 6) Create user (interactive)
        if (confirm('Create a user?')) {
            $email = text(
                label: 'Email',
                required: 'Email required.',
                validate: function (string $value) {
                    $v = Validator::make(['email' => $value], [
                        'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class, 'email')],
                    ]);

                    return $v->fails() ? $v->errors()->all() : null;
                },
            );

            $plain = password(
                label: 'Password',
                required: 'Password required.',
                validate: function (string $value) {
                    $v = Validator::make(['password' => $value], ['password' => Password::defaults()]);

                    return $v->fails() ? $v->errors()->all() : null;
                },
            );

            $user = User::factory()->create([
                'email' => $email,
                'password' => $plain,
            ]);

            if (class_exists(Gatekeeper::class) && confirm('Assign Gatekeeper permissions?')) {
                Gatekeeper::systemActor()
                    ->assignAllPermissionsToModel($user, [GatekeeperPermission::View, GatekeeperPermission::Manage]);
            }

            $this->components->info("User created: {$user->email}");
        }

        $this->components->success('Development environment ready.');

        return self::SUCCESS;
    }
}
