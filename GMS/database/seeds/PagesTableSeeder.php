<?php

use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    public function run()
    {
        Page::create([
            'title' => 'About Us',
            'content' => 'This is the About Us page content.',
        ]);

        Page::create([
            'title' => 'Contact',
            'content' => 'This is the Contact page content.',
        ]);
    }
}
