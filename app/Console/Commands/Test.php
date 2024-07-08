<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchWordsWrongJob;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FetchWordsWrongJob::dispatch();
    }
}
