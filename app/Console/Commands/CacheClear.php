<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CacheClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all application caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('cache:clear', []);
        $this->call('view:clear', []);
        $this->call('route:clear', []);
        $this->call('queue:clear', []);
        $this->call('event:clear', []);
        $this->call('debugbar:clear', []);
        $this->call('config:clear', []);
        $this->call('auth:clear-resets', []);
        $this->call('optimize:clear', []);
    }
}
