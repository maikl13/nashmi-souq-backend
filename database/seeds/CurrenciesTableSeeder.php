<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'name' => 'الجنيه المصري',
                'slug' => 'egp',
                'code' => 'EGP',
                'symbol' => 'ج م',
            ],
            [
                'name' => 'الدولار الأمريكي',
                'slug' => 'usd',
                'code' => 'USD',
                'symbol' => '$',
            ],
        ]);
    }
}
