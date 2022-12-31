<?php

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'سيارات وقطع غيار',
                [
                    'سيارات للبيع',
                    'سيارات للايجار',
                    'قطع غيار سيارات',
                    'دراجات بخاريه وهوائيه',
                    'شاحنات ونقل',
                    'معدات وآليات',
                    'اكسسوارات ولوازم سيارات.',
                ],
            ],
            [
                'الموضه والجمال',
                [
                    'ملابس حريمي',
                    'ملابس رجالي',
                    'ملابس اولاد',
                    'مستحضرات تجميل',
                    'اكسسوارات',
                    'عنايه شخصيه',
                ],
            ],
            [
                'عقارات',
                [
                    'فلل للبيع',
                    'فلل للايجار',
                    'شقق للبيع',
                    'شقق للايجار',
                    'شاليهات واستراحات للبيع',
                    'شاليهات واستراحات للايجار',
                    'عقار تجاري للبيع',
                    'عقار تجاري للايجار',
                    'عمارات واراض بناء',
                    'اراضي زراعيه للبيع',
                    'اراضي زراعيه للايجار',
                    'غرف فندقيه وشقق للايجار اليومي',
                ],
            ],
            [
                'مستلزمات اطفال',
                [
                    'عناية صحة الام والطفل',
                    'ادوات تغذيه اطفال',
                    'ملابس اطفال',
                    'العاب اطفال',
                ],
            ],
            [
                'الكترونيات واجهزه منزليه',
            ],
            [
                'اثاث منزلي وفندقي وديكور',
            ],
            [
                'هواتف محموله وملحقاتها',
            ],
            [
                'كمبيوترات وتابلت وطابعات',
            ],
            [
                'عرض وطلب وظائف',
            ],
            [
                'تجاره وصناعه',
                [
                    'مصانع للبيع',
                    'مصانع للايجار',
                    'معدات صناعيه',
                    'معدات مطاعم',
                    'معدات ولوازم المعامل',
                    'أثاث ومستلزمات المكاتب',
                    'مواد بناء وتشطيبات',
                    'أخري',
                ],
            ],
            [
                'خدمات',
                [
                    'شركات تخليص جمركي',
                    'بناء وتصميم المواقع والتطبيقات',
                    'خدمات منزليه',
                    'توصيل وشحن',
                    'دروس تعليميه',
                    'خدمات مناسبات الافراح والمؤتمرات',
                    'أخري',
                ],
            ],
            [
                'تحف ورياضه وسفر',
                [
                    'تحف ومقتنيات',
                    'كتب والعاب لوحيه',
                    'تذاكر وقسائم',
                    'ادوات رياضيه',
                    'شنط سفر',
                    'أخري',
                ],
            ],
            [
                'استوكات بضاعه',
            ],
            [
                'تصدير واستيراد',
            ],
        ];

        $icons = [
            'fas fa-align-justify',
            'fas fa-adjust',
            'fas fa-ambulance',
            'fab fa-amazon',
            'fab fa-angellist',
            'fab fa-angular',
            'fab fa-apple',
            'fas fa-archive',
            'fas fa-asterisk',
            'fas fa-balance-scale',
            'fas fa-bath',
            'far fa-bell',
            'fas fa-bicycle',
            'fas fa-binoculars',
            'fas fa-birthday-cake',
            'fas fa-bullhorn',
            'far fa-building',
            'fas fa-car',
            'fas fa-chart-pie',
            'fas fa-code',
            'fas fa-cogs',
            'fas fa-coffee',
            'fas fa-dolly-flatbed',
        ];

        foreach ($categories as $category) {
            $c = Category::create([
                'name' => $category[0],
                'slug' => Str::slug($category[0]),
                'icon' => $icons[rand(0, 21)],
            ]);

            if (isset($category[1])) {
                foreach ($category[1] as $sub_category) {
                    $count = Category::where('slug', Str::slug($sub_category))->count();
                    $slug = $count ? Str::slug($sub_category).uniqid() : Str::slug($sub_category);
                    Category::create([
                        'name' => $sub_category,
                        'slug' => $slug,
                        'category_id' => $c->id,
                        'icon' => $icons[rand(0, 21)],
                    ]);
                }
            }
        }
    }
}
