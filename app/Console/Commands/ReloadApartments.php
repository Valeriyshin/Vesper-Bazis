<?php

namespace App\Console\Commands;

use App\Models\Apartment;
use Illuminate\Console\Command;

class ReloadApartments extends Command
{

    protected $signature = 'app:reload-apartments {--wipe}';


    protected $description = 'Reload apartments from crm';

    public function handle(): void
    {
        if($this->option('wipe')){
            Apartment::query()->truncate();
        }
        Apartment::reloadAll($this);
    }
}
