<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionProperty;

class GenerateMigrationsFromModels extends Command
{
    protected $signature = 'generate:migrations';
    protected $description = 'Generate migrations from models';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $modelsPath = app_path('Models');
        $models = File::allFiles($modelsPath);

        foreach ($models as $model) {
            $modelName = $model->getFilenameWithoutExtension();
            $modelNamespace = "App\\Models\\{$modelName}";
            if (!class_exists($modelNamespace)) {
                continue;
            }

            $modelInstance = new $modelNamespace;
            $tableName = $modelInstance->getTable();
            $fillable = $modelInstance->getFillable();
            $dates = $modelInstance->getDates();
            $casts = $modelInstance->getCasts();
            $relations = $this->getRelations($modelInstance);

            $migrationName = "create_{$tableName}_table";
            $migrationFile = database_path("migrations/" . date('Y_m_d_His') . "_{$migrationName}.php");

            $migrationContent = $this->generateMigrationContent($modelName, $tableName, $fillable, $dates, $casts, $relations);
            File::put($migrationFile, $migrationContent);

            $this->info("Migration for {$modelName} created successfully.");
        }
    }

    protected function generateMigrationContent($modelName, $tableName, $fillable, $dates, $casts, $relations)
    {
        $columns = '';
        foreach ($fillable as $column) {
            $columns .= $this->generateColumn($column, $casts) . "\n            ";
        }

        // Handling timestamps and other date columns
        foreach ($dates as $date) {
            if (!in_array($date, ['created_at', 'updated_at', 'deleted_at'])) {
                $columns .= "\$table->timestamp('{$date}')->nullable();\n            ";
            }
        }

        // Adding relations (foreign keys)
        foreach ($relations as $relation) {
            $columns .= "\$table->foreignId('{$relation['foreign_key']}')->constrained('{$relation['related_table']}')->onDelete('cascade');\n            ";
        }

        return "<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create{$modelName}Table extends Migration
{
    public function up()
    {
        Schema::create('{$tableName}', function (Blueprint \$table) {
            \$table->id();
            {$columns}
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('{$tableName}');
    }
}
";
    }

    protected function generateColumn($column, $casts)
    {
        $type = 'string'; // Default type

        if (isset($casts[$column])) {
            switch ($casts[$column]) {
                case 'integer':
                case 'int':
                    $type = 'integer';
                    break;
                case 'boolean':
                case 'bool':
                    $type = 'boolean';
                    break;
                case 'float':
                case 'double':
                case 'decimal':
                    $type = 'decimal(10, 2)';
                    break;
                case 'date':
                    $type = 'date';
                    break;
                case 'datetime':
                case 'timestamp':
                    $type = 'timestamp';
                    break;
                case 'json':
                    $type = 'json';
                    break;
                default:
                    $type = 'string';
            }
        }

        return "\$table->{$type}('{$column}')";
    }

    protected function getRelations($modelInstance)
    {
        $relations = [];

        $reflection = new ReflectionClass($modelInstance);
        foreach ($reflection->getMethods() as $method) {
            if ($method->class != get_class($modelInstance) || !$method->isPublic()) {
                continue;
            }

            $returnType = $method->getReturnType();
            if ($returnType && is_subclass_of($returnType->getName(), 'Illuminate\Database\Eloquent\Relations\Relation')) {
                $relationType = (new ReflectionClass($returnType->getName()))->getShortName();
                $relatedModel = $method->invoke($modelInstance)->getRelated();
                $relatedTable = $relatedModel->getTable();
                $foreignKey = $method->invoke($modelInstance)->getForeignKeyName();

                $relations[] = [
                    'type' => $relationType,
                    'related_model' => get_class($relatedModel),
                    'related_table' => $relatedTable,
                    'foreign_key' => $foreignKey,
                ];
            }
        }

        return $relations;
    }
}
