<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\State;
use App\Models\Area;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
        	[
        		'مصر',
        		[
		            ['القاهرة'],
		            ['الجيزة'],
		            ['الأسكندرية'],
		            ['الدقهلية'],
		            ['البحر الأحمر'],
		            ['البحيرة'],
		            ['الفيوم'],
		            ['الغربية'],
		            ['الإسماعلية'],
		            ['المنوفية'],
		            ['المنيا'],
		            ['القليوبية'],
		            ['الوادي الجديد'],
		            ['السويس'],
		            ['اسوان'],
		            ['اسيوط'],
		            ['بني سويف'],
		            ['بورسعيد'],
		            ['دمياط'],
		            ['الشرقية'],
		            ['جنوب سيناء'],
		            ['كفر الشيخ'],
		            ['مطروح'],
		            ['الأقصر'],
		            ['قنا'],
		            ['شمال سيناء'],
		            ['سوهاج'],
        		]
        	]
        ];


        foreach($countries as $country){
        	$c = Country::create([
        		'name' => $country[0],
        		'slug' => Str::slug($country[0])
        	]);

        	if( isset($country[1]) ){
        		foreach($country[1] as $state){
		        	State::create([
		        		'name' => $state[0],
		        		'slug' => Str::slug($state[0]),
		        		'country_id' => $c->id
		        	]);

        			if( isset($state[1]) ){
			        	foreach ($state[1] as $area) {
				        	Area::create([
				        		'name' => $state[0],
				        		'slug' => Str::slug($state[0]),
				        		'country_id' => $c->id
				        	]);
			        	}
			        }
		        }

        	}
        }
    }
}
