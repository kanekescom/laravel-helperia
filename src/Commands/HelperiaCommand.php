<?php

namespace Kanekescom\Helperia\Commands;

use Illuminate\Console\Command;

class HelperiaCommand extends Command
{
    public $signature = 'laravel-helperia';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
