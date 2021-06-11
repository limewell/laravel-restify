<?php

namespace Limewell\LaravelRestify\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class MakeRestifyControllerCommand extends GeneratorCommand
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
    protected $name = 'restify:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Restify Controller';

    /**
     * @var string
     */
    protected $type = 'Controller';

    /**
     * @var string
     */
    protected string $model = '';

    /**
     * @var string
     */
    private string $stub = 'controller.stub';

    /**
     *
     */
    public function construct_facade()
    {
        $this->model = Str::remove($this->type, $this->argument('name'));
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        return file_exists($customPath = $this->laravel->basePath("stubs/vendor/restify/$this->stub"))
            ? $customPath
            : __DIR__ . "/../../../stubs/$this->stub";
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Controllers\Api';
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
        $content = str_replace('{{ namespacedModel }}', $this->qualifyModel($this->model), $content);
        $content = str_replace('{{ model }}', $this->model, $content);
        $content = str_replace('{{ modelVariable }}', Str::camel($this->model), $content);

        file_put_contents($path, $content);

        /*Route Generate*/
        self::generateApiRoute($class);
        /*Route Generate*/

        return true;
    }

    /**
     * @param string $class
     * @return bool
     */
    protected function generateApiRoute(string $class): bool
    {
        $apiRoutePath = base_path('routes/api.php');

        if (!file_exists($apiRoutePath)) {
            return false;
        }

        $content = "Route::apiResource('{{ modelVariable }}', $class::class);\n";

        // Update the file content with additional data (regular expressions)
        $route = str_replace('{{ modelVariable }}', Str::camel(Str::plural($this->model)), $content);

        if (!strpos(file_get_contents(base_path('routes/api.php')), $route)) {
            //route does not exist create new one
            file_put_contents($apiRoutePath, $route, FILE_APPEND);
        }

        return true;
    }

}
