<?php

use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business')->insert([
            'name' => null,
            'desc_name' => null,
            'currency_id' => null,
            'start_date' => null,
            'tax' => null,
            'discount_name' => null,
            'discount_value' => null,
            'logo' => 'logo.png',
            'icon' => null
        ]);
    }
}
