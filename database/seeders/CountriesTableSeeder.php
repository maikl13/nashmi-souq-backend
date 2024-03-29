<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                'eg',
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
                ],
                1,
            ],
            [
                'المملكة العربية السعودية',
                'sa',
                [
                    ['الرياض', [
                        'الرياض',
                        'الدرعيه',
                        'الخرج',
                        'الدوادمي',
                        'المجمعه',
                        'القويعيه',
                        'وادي الدواسر',
                        'الزلفي',
                        'شقراء',
                        'حوطة بني تميم',
                        'عفيف',
                        'السليل',
                        'ضرماء',
                        'المزاحميه',
                        'رماح',
                        'ثادق',
                        'حريملاء',
                        'الحريف',
                        'الغاط',
                    ]],
                    ['جده'],
                    ['الطايف'],
                    ['منطقة مكه المكرمه', [
                        'مكه المكرمه',
                        'القنفذه',
                        'الليث',
                        'رابغ',
                        'الجموم',
                        'خليص',
                        'الكامل',
                        'الخرمه',
                        'رنيه',
                        'تربه',
                    ]],
                    ['المدينه المنوره', [
                        'المدينه المنوره',
                        'العلا',
                        'المهد',
                        'الحناكيه',
                    ]],
                    ['الاحساء'],
                    ['المنطقه الشرقيه', [
                        'الدمام',
                        'الخبر',
                        'حفر الباطن',
                        'الجبيل',
                        'القطيف',
                        'الخفجي',
                        'رأس تنوره',
                        'ابقيق',
                        'النعيريه',
                        'قرية العليا',
                        'الخرخير',
                    ]],
                    ['القصيم', [
                        'بريده',
                        'عنيزه',
                        'الرس',
                        'المذنب',
                        'البكيريه',
                        'البدائع',
                        'الاسياح',
                        'النبهانيه',
                        'الشماسيه',
                        'عيون الجواء',
                        'رياض الخبراء',
                    ]],
                    ['منطقة عسير', [
                        'ابها',
                        'خميس مشيط',
                        'بيشه',
                        'النماص',
                        'محايل',
                        'سراة عبيده',
                        'تثليث',
                        'رجال ألمع',
                        'بالقرن',
                        'احد رفيده',
                        'ظهران الجنوب',
                        'المجارده',
                    ]],
                    ['منطقة جازان', [
                        'جازان',
                        'صبيا',
                        'ابوعريش',
                        'صامطه',
                        'الحرث',
                        'ضمد',
                        'الريث',
                        'بيش',
                        'فراسان',
                        'الدائر',
                        'احد المسارحه',
                        'العيدابي',
                        'العارضه',
                        'القياس',
                    ]],
                    ['الباحه', [
                        'الباحه',
                        'بلجرشي',
                        'المندق',
                        'المخواه',
                        'العقيق',
                        'قلوه',
                        'القري',
                    ]],
                    ['حائل', [
                        'حائل',
                        'بقعاء',
                        'الغزاله',
                        'الشنان',
                    ]],
                    ['منطقة تبوك', [
                        'تبوك',
                        'الوجه',
                        'ضباء',
                        'حقل',
                        'تيماء',
                        'املج',
                        'البدع',
                    ]],
                    ['الجوف', [
                        'سكاكا',
                        'القريات',
                        'دومة الجندل',
                    ]],
                    ['الحدود الشماليه', [
                        'عرعر',
                        'رفحاء',
                        'طريف',
                    ]],
                    ['ينبع'],
                ],
                2,
            ],
        ];

        foreach ($countries as $country) {
            $c = Country::create([
                'name' => $country[0],
                'code' => $country[1],
                'slug' => Str::slug($country[0]),
                'currency_id' => $country[3],
            ]);

            if (isset($country[2])) {
                foreach ($country[2] as $state) {
                    $s = State::create([
                        'name' => $state[0],
                        'slug' => Str::slug($state[0]),
                        'country_id' => $c->id,
                    ]);

                    if (isset($state[1])) {
                        foreach ($state[1] as $area) {
                            Area::create([
                                'name' => $area,
                                'slug' => Str::slug($area),
                                'state_id' => $s->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
