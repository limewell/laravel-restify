<?php

namespace Limewell\LaravelRestify\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class MakeRestifyCollectionCommand extends GeneratorCommand
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
    protected $name = 'restify:collection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Restify Collection';

    /**
     * @var string
     */
    protected $type = 'Collection';

    /**
     * @var string
     */
    protected string $model = '';

    /**
     * @var string
     */
    private string $stub = 'collection.stub';

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

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Resources';
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
        $content = str_replace('{{ model }}', $this->model, $content);

        file_put_contents($path, $content);

        return true;
    }
}
