<?php

namespace App\Console\Commands;

use App\Jobs\Parsers\Petrovich\MainHandlerJob;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ParserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        dispatch(new MainHandlerJob())->onQueue('petrovich')->delay(Carbon::now()->addSeconds(mt_rand(1, 3)));
    }
}
