<?php

namespace App\Console\Commands;

use App\Jobs\FetchWordAndStorage;
use Illuminate\Console\Command;

class FarmWordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:farm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Farm words from API and storage in database';

    public function handle(): void
    {
        FetchWordAndStorage::dispatch();
    }
}
