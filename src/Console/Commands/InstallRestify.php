<?php

namespace Limewell\LaravelRestify\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallRestify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restify:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Restify';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Installing Restify...');

        $this->info('Publishing configuration...');

        if (!$this->configExists()) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration(true);
            } else {
                $this->error('Existing configuration was not overwritten');
            }
        }

        $this->info('Installed Restify');
        return 0;
    }

    /**
     * @return bool
     */
    private function configExists(): bool
    {
        return File::exists(config_path('restify.php'));
    }

    /**
     * @return bool
     */
    private function shouldOverwriteConfig(): bool
    {
        return $this->confirm('Config file already exists. Do you want to overwrite it?', false);
    }

    /**
     * @param false $forcePublish
     */
    private function publishConfiguration(bool $forcePublish = false)
    {
        $params = [
            '--provider' => "Limewell\LaravelRestify\LaravelRestifyServiceProvider",
            '--tag' => "config"
        ];
        if ($forcePublish === true) {
            $params['--force'] = '';
        }
        $this->call('vendor:publish', $params);
    }
}
