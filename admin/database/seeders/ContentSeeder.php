<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Content::create([
            'title' => 'Sample Content 1',
            'slug' => 'sample-content-1',
            'body' => 'This is the body of sample content 1.',
        ]);

        Content::create([
            'title' => 'Sample Content 2',
            'slug' => 'sample-content-2',
            'body' => 'This is the body of sample content 2.',
        ]);
    }
}
