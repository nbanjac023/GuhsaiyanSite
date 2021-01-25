<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;
use Schema;
use Storage;

class CreateFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:folders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates folders based on category names from DB';

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
        if (Schema::hasTable('categories')) {
            $categories = Category::all();
            foreach ($categories as $category) {
                $this->info('Creating folder ' . $category->name);
                Storage::makeDirectory('/public/' . $category->name);
            }
        }
    }
}
