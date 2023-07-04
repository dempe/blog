<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Cleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes deleted posts and tags.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
