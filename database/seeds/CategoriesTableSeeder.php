<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;

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
        		]
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
				]
        	],
        	[
        		'مستلزمات اطفال',
        		[
        			'عناية صحة الام والطفل',
					'ادوات تغذيه اطفال',
					'ملابس اطفال',
					'العاب اطفال',
        		]
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
        		]
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
        		]
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
        		]
        	],
        	[
        		'استوكات بضاعه',
        	],
        	[
        		'تصدير واستيراد',
        	],
        ];


        foreach($categories as $category){
        	$c = Category::create([
        		'name' => $category[0],
        		'slug' => Str::slug($category[0])
        	]);

        	if( isset($category[1]) ){
        		foreach($category[1] as $sub_category){
                    $count = Subcategory::where('slug', Str::slug($sub_category))->count();
                    $slug = $count ? Str::slug($sub_category).uniqid() : Str::slug($sub_category);
		        	Subcategory::create([
		        		'name' => $sub_category,
		        		'slug' => $slug,
		        		'category_id' => $c->id
		        	]);
		        }
        	}
        }

    }
}
