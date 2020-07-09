<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// delete all users before seeding to avoid unique fields error
        // DB::table('users')->truncate();

    	$date = date("Y-m-d H:i:s");
        $password = Hash::make('password');
        
        DB::table('users')->insert([
            [
                'name' => 'SuperAdmin',
                'username' => 'superadmin',
                'email' => 'superadmin@example.com',
                'phone' => '+201004503999',
                'phone_national' => '01004503999',
                'role_id' => '2',
                'password' => $password ,
                'email_verified_at' => now(),
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'name' => 'Mahmoud Abdelhamid',
                'username' => 'mahmoud',
                'email' => 'mahmoud@example.com',
                'phone' => '+201099902638',
                'phone_national' => '01099902638',
                'role_id' => '1',
                'password' => $password ,
                'email_verified_at' => now(),
                'created_at' => $date,
                'updated_at' => $date
            ],
        	// [
        	// 	'name' => 'Admin',
        	// 	'username' => 'admin',
        	// 	'email' => 'admin@example.com',
         //        'phone' => '+201099902639',
         //        'phone_national' => '01099902639',
         //        'role_id' => '3',
        	// 	'password' => $password ,
         //        'email_verified_at' => now(),
        	// 	'created_at' => $date,
        	// 	'updated_at' => $date
        	// ],
        ]);
        // factory(App\Models\User::class, 20)->create();
    }
}
