<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JoysailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('joysail_categories_members')->insert([
        [
            'name' => 'Team Manager',
        ],
        [
            'name' => 'Owner',
        ],
        [
            'name' => 'Diver',
        ],
        [
            'name' => 'Captain',
        ]]);

        DB::table('joysail_attendants_types')->insert([[
            'name' => 'Collaborator',
        ],
        [
            'name' => 'Media',
        ],
        [
            'name' => 'Guests',
        ],
        ]);
    }
}
