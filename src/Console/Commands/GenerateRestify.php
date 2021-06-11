<?php

namespace Limewell\LaravelRestify\Console\Commands;

use Illuminate\Console\Command;

class GenerateRestify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restify:generate {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'REST Api Generator With API Resources';

    /**
     * @var string
     */
    protected string $model = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = ucfirst($model);
    }

    /**
     *
     */
    public function construct_facade()
    {
        $this->setModel($this->option('model') ?? '');
        if (empty($this->getModel())) {
            $this->setModel($this->ask('Enter Model Name:'));
        }
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        //constructor
        $this->construct_facade();

        $model_directory_path = config('restify.model_directory_path');

        if (!file_exists($modelPath = base_path("$model_directory_path/$this->model.php"))) {
            $this->error('Model does not exist at ' . $modelPath);
            $this->line('Please Provide Valid Model Directory Path or Model Name Same As File Name');
            return false;
        }

        $this->call('restify:resource', [
            'name' => $this->getModel() . 'Resource'
        ]);

        $this->call('restify:collection', [
            'name' => $this->getModel() . 'Collection'
        ]);

        /*Request*/
        $this->call('restify:request', [
            'name' => $this->getModel() . 'StoreRequest'
        ]);
        $this->call('restify:request', [
            'name' => $this->getModel() . 'UpdateRequest'
        ]);
        /*Request*/

        $this->call('restify:controller', [
            'name' => $this->getModel() . 'Controller'
        ]);

        return true;
    }

}
