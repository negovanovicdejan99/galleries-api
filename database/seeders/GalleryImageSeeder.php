<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\GalleryImage::factory()->times(200)->create();
        }
}
