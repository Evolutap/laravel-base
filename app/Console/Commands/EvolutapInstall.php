<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EvolutapInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evolutap:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finalizar instalação inicial';

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
    public function handle()
    {
        $this->info('Select you options.');

        $jetstream = strtolower($this->choice(
            'Which stack?',
            ['Livewire', 'Inertia'],
            0
        ));

        $teams = ($this->choice(
            'Install Jetstream teams?',
            ['Yes', 'No'],
            0
        ) === 'Yes' ? true : false);

        $this->info('Installing Jetstream');

        $this->call("jetstream:install", ['stack' => $jetstream, '--teams' => $teams]);

        $this->info('Publishing Jetstream Components');

        $this->call("vendor:publish", ['--tag' => 'jetstream-views']);

        $this->info('Don\'t forget to run "npm install && npm run dev" and php artisan migrate');

        $this->info('The installation was successful!');
    }
}
