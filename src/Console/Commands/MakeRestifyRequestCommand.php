<?php

namespace Limewell\LaravelRestify\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class MakeRestifyRequestCommand extends GeneratorCommand
{
    /**
     * @var bool
     */
    protected $hidden = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'restify:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Restify Request';

    /**
     * @var string
     */
    protected $type = 'Request';

    /**
     * @var string
     */
    protected string $model = '';

    /**
     * @var string
     */
    private string $stub = 'request.php.stub';

    /**
     *
     */
    public function construct_facade()
    {
        $model_name = Str::remove($this->type, $this->argument('name'));
        $model_name = Str::remove('Store', $model_name);
        $model_name = Str::remove('Update', $model_name);
        $this->model = $model_name;
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        if (file_exists($stubPath = base_path("stubs/vendor/laravel-restify/$this->stub"))) {
            return $stubPath;
        } else {
            return __DIR__ . "/../../../stubs/$this->stub";
        }
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Requests\Api';
    }

    /**
     * Execute the console command.
     *
     * @return bool
     * @throws FileNotFoundException
     */
    public function handle(): bool
    {
        //constructor
        $this->construct_facade();

        $handle = parent::handle();

        if ($handle !== false) {
            $this->doOtherOperations();
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function doOtherOperations(): bool
    {
        // Get the fully qualified class name (FQN)
        $class = $this->qualifyClass($this->getNameInput());

        // get the destination path, based on the default namespace
        $path = $this->getPath($class);

        $content = file_get_contents($path);

        // Update the file content with additional data (regular expressions)
        $model = app($this->qualifyModel($this->model));
        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        $print_columns = null;
        foreach ($columns as $column) {
            $print_columns .= "'" . $column . "'" . " => 'required'," . "\n \t\t\t";
        }
        $content = str_replace('{{columns}}', $print_columns, $content);


        file_put_contents($path, $content);

        return true;
    }
}
