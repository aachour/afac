<?php

namespace Database\Seeders;

use App\Models\Entries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

         $allNews = [

            [
                'title_en' => 'AFAC Grantees on Show at BBIMF 2018',
                'title_ar' => 'يعود مهرجان بيروت أند بيوند الدولي للموسيقى 2018 ف...',
            ],

            [
                'title_en' => 'Three AFAC-supported Films Awarded at Karama Film Festival',
                'title_ar' => 'فوز ثلاثة أفلام مدعومة من آفاق في مهرجان الكرامة',
            ],

            [
                'title_en' => 'Three AFAC-supported Films Play CIFF 2018',
                'title_ar' => 'ثلاثة أفلام مدعومة من آفاق تشارك في مهرجان القاهرة...',
            ],

            [
                'title_en' => 'Three AFAC-supported films awarded at El Gouna Film Festival',
                'title_ar' => 'ثلاثة أفلام مدعومة من قبل آفاق تفوز بالجوائز في مه...',
            ],

            [
                'title_en' => 'A Drowning Man nominated for the BAFTA Best British Short',
                'title_ar' => '"رجل يغرق" ينافس على جائزة أفضل فيلم بريطاني قصير ...',
            ],

            [
                'title_en' => 'And the Oscar nominee is: AFAC-supported “Of Fathers and Sons”',
                'title_ar' => '"عن الآباء والأبناء" في ترشيحات الأوسكار 2019',
            ],

            [
                'title_en' => 'AFAC’s Documentary Photography Program in Spotlight',
                'title_ar' => 'برنامج آفاق للتصوير الفوتوغرافي الوثائقي في "أسبوع..."',
            ],

            [
                'title_en' => 'Three AFAC-supported Films Play Berlinale 2019',
                'title_ar' => 'ثلاثة أفلام مدعومة من آفاق في مهرجان برلين السينما...',
            ],

            [
                'title_en' => 'Documentary Convention 2019 Registration Now Open',
                'title_ar' => 'فتح باب التسجيل لملتقى السينما الوثائقية',
            ],

            [
                'title_en' => 'AFAC-supported Film Secures Double Win at Berlinale',
                'title_ar' => 'فوز مزدوج لفيلم "الحديث عن الأشجار" في برلينالي 20...',
            ],

            [
                'title_en' => 'AFAC Opens Call for 2019 First Grants Cycle',
                'title_ar' => 'فتح باب التقديم للدورة الأولى من منح 2019',
            ],

            [
                'title_en' => 'At the intersection of culture and technology',
                'title_ar' => 'التقاطع بين الثقافة والتكنولوجيا',
            ],

            [
                'title_en' => 'The story on India by Arundhati Ghosh',
                'title_ar' => 'قصّة عن الهند مع أرونداتي غوش',
            ],

            [
                'title_en' => 'Atelier for Young Festival Managers alongside NEXT',
                'title_ar' => 'مشغل مدراء المهرجانات الشباب',
            ],

        ];

        foreach ($allNews as $news) {
            Entries::updateOrCreate(['type_id'=>'7','news_title' => $news["title_en"],'news_title_arabic' => $news["title_ar"] , 'published'=>'1']);
        }

    }
}
