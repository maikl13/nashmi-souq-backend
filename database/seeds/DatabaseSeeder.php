<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CurrenciesTableSeeder::class,
            CountriesTableSeeder::class,
        	UsersTableSeeder::class,
            SettingsTableSeeder::class,
            CategoriesTableSeeder::class,
            ListingsTableSeeder::class,
        ]);
    }
}
