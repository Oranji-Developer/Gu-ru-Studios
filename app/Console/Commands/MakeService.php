<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : Name of the service (e.g., /Test/TestService)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class in the App\Services directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = ltrim($this->argument('name'), '/'); // Remove leading slash

        $namespace = 'App\Services\\' . str_replace('/', '\\', dirname($name));
        $path = app_path('Services/' . str_replace('\\', '/', $name) . '.php');

        $className = class_basename($name);

        $directory = dirname($path);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $template = <<<PHP
<?php

namespace $namespace;

use App\Services\Abstracts\CrudAbstract;

class $className extends CrudAbstract
{
    // Implement service logic here
}
PHP;

        if (File::exists($path)) {
            $this->error("The service $name already exists!");
            return Command::FAILURE;
        }

        File::put($path, $template);

        $this->info("Service $name has been successfully created at $path");

        return Command::SUCCESS;
    }
}
