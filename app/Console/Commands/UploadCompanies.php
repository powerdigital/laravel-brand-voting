<?php

namespace App\Console\Commands;

use App\Company;
use Illuminate\Console\Command;

class UploadCompanies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:upload {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploading companies into database from csv file';

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
     */
    public function handle()
    {
        try {
            $records = [];

            $file = $this->argument('file');

            if (($handle = fopen($file, "rb")) !== false) {
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    $records[] = [
                        'name' => $data[0],
                        'category_id' => $data[1],
                        'logo' => $data[2],
                        'description' => $data[3],
                    ];
                }

                fclose($handle);
            }

            Company::insert($records);

            $this->info('Companies successfully inserted into database');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
