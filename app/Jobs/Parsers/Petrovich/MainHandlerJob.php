<?php

namespace App\Jobs\Parsers\Petrovich;

use App\Services\Parsers\Petrovich\Handlers\MainHandler;
use App\Services\Parsers\Petrovich\PetrovichParser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class MainHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(__METHOD__);

        $parser = new PetrovichParser();
        $parser->run(null, MainHandler::class);

    }
}
