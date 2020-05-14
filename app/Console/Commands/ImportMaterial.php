<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MaterialsImport;

class ImportMaterial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:material {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Material Excel';

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
        // $this->output->title('Starting import');
        // (new MaterialImport)->withOutput($this->output)->import($this->argument('filename'));
        // $this->output->success('Import successful');

        Excel::import(new MaterialsImport, $this->argument('filename'));
    }
}
