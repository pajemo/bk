<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminContent;

class AdminContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminContent::create([
            'title' => 'Admin Content 1',
            'body' => 'This is the body of admin content 1.',
        ]);

        AdminContent::create([
            'title' => 'Admin Content 2',
            'body' => 'This is the body of admin content 2.',
        ]);
    }
}
