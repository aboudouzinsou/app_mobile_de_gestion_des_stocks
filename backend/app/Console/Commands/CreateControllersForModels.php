<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateControllersForModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controllers-for-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create controllers for each model in the app/Models directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $modelsPath = app_path('Models');

        if (!File::exists($modelsPath)) {
            $this->error("The models directory does not exist.");
            return 1;
        }

        $modelFiles = File::files($modelsPath);

        foreach ($modelFiles as $modelFile) {
            $modelName = pathinfo($modelFile, PATHINFO_FILENAME);
            $controllerName = $modelName . 'Controller';

            $command = "php artisan make:controller {$controllerName} --resource";
            $this->info("Creating controller for model: {$modelName}");
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                $this->error("Error creating controller for model: {$modelName}");
                $this->error(implode("\n", $output));
            } else {
                $this->info("Controller {$controllerName} created successfully.");
            }
        }

        $this->info("All controllers created.");
        return 0;
    }
}