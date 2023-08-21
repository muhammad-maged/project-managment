<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FetchFromMongoDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:mongodb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from MongoDB cloud database and store in local MySQL database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Connect to MongoDB cloud database
        $client = new \MongoDB\Client(env('MONGODB_CONNECTION_STRING'));
        $collection = $client->test->example;

        // Fetch data from MongoDB
        $data = $collection->find();

        // Store data in local MySQL database
        foreach ($data as $document) {
            // Assuming 'examples' is a table in your local MySQL database
            DB::table(env('MYSQL_TABLE_NAME'))->insert((array) $document);
        }
    }
}

