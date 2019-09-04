<?php

namespace App\Console\Commands;

use App;

use Illuminate\Console\Command;

class IdeHelperMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ide-helper:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all the IDE helper files on local environment only.';

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
     * @return mixed
     */
    public function handle()
    {
        if (App::environment('local')) {
            $this->call('ide-helper:generate');
            $this->call('ide-helper:meta');
            $this->call('ide-helper:models', [
                '--nowrite' => true,
            ]);
        }

        return true;
    }
}
