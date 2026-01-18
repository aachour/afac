<?php

namespace Database\Seeders;

use App\Models\Entries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $resources = [

            ['title_en' => 'AFAC Annual Report 2017 - English', 'title_ar' => 'تقرير آفاق السنوي 2017 - النسخة الإنكليزية'],
            ['title_en' => 'AFAC Annual Report 2017 - Arabic', 'title_ar' => 'تقرير آفاق السنوي 2017 - النسخة العربية'],

            ['title_en' => 'Imagining the Future: The Arab World in the Aftermath', 'title_ar' => 'منتدى المستقبل متخيَّلاً: العالم العربي على أنقاض'],
            ['title_en' => 'AFAC Annual Report 2016', 'title_ar' => 'تقرير آفاق السنوي 2016'],

            ['title_en' => 'Arab Novel Writing Program Info-graph', 'title_ar' => 'برنامج كتابة الرواية العربية'],
            ['title_en' => 'AFAC Evaluation Process', 'title_ar' => 'آفاق - عملية التقييم'],

            ['title_en' => 'Applicants and Grantees Info-graph 2007-2015', 'title_ar' => 'المتقدّمون بالطلبات والحاصلين على المنح 2007-2015'],

            ['title_en' => 'How to Tell When The Rebels Have Won - Exhibition', 'title_ar' => 'السنة العاشرة - معرض'],

            ['title_en' => 'Audit Report 2017', 'title_ar' => 'التقرير المالي 2017'],

            ['title_en' => 'AFAC Ten-Year Evaluation', 'title_ar' => 'تقييم للسنوات العشر الماضية'],

            ['title_en' => 'AFAC selection of Photos', 'title_ar' => 'صور مختارة'],

            ['title_en' => 'ACEF Book 2015', 'title_ar' => 'برنامج تمويل المبادرة والإبداع في العالم العربي'],
            ['title_en' => 'AFAC 2015 Annual Report', 'title_ar' => 'تقرير آفاق السنوي للعام 2015'],

            ['title_en' => 'ACEF Book 2014', 'title_ar' => 'برنامج تمويل المبادرة والإبداع في العالم العربي'],

            ['title_en' => 'Sudan Field Visit - English', 'title_ar' => 'زيارة آفاق الميدانية الى السودان - إنكليزي'],
            ['title_en' => 'Sudan Field Visit - Arabic', 'title_ar' => 'زيارة آفاق الميدانية الى السودان - عربي'],

            ['title_en' => 'AFAC 2014 annual report', 'title_ar' => 'تقرير آفاق السنوي للعام 2014'],

            ['title_en' => 'InVisible Public Art Commission', 'title_ar' => 'مشروع الظاهر الخفي الفنّي في المكان العام'],

            ['title_en' => 'Morocco and Mauritania field visit', 'title_ar' => 'زيارة ميدانية الى المغرب وموريتانيا'],

            ['title_en' => 'AFAC Film Week 2014 - English', 'title_ar' => 'أسبوع آفاق السينمائي 2014 - إنكليزي'],
            ['title_en' => 'AFAC Film Week 2014 - Arabic', 'title_ar' => 'أسبوع آفاق السينمائي 2014 - عربي'],

            ['title_en' => 'AFAC Jurors 2007 to 2013 - Arabic', 'title_ar' => 'محكّمو آفاق بين 2007 و2013 - عربي'],

            ['title_en' => 'AFAC 2013 annual report - English', 'title_ar' => 'تقرير آفاق السنوي للعام 2013 - إنكليزي'],
            ['title_en' => 'AFAC 2013 annual report - Arabic', 'title_ar' => 'تقرير آفاق السنوي للعام 2013 - عربي'],

            ['title_en' => 'AFAC Grantee Survey', 'title_ar' => 'إستطلاع آراء المستفيدين من منح آفاق'],

            ['title_en' => 'AFAC visits Saudi Arabia', 'title_ar' => 'آفاق تزور السعودية - الرياض وجدّة'],

            ['title_en' => 'AFAC 2012 annual report', 'title_ar' => 'تقرير آفاق السنوي للعام 2012'],

            ['title_en' => 'AFAC Visits Algeria', 'title_ar' => 'آفاق تزور الجزائر'],

            ['title_en' => 'AFAC Express Final Report', 'title_ar' => 'التقرير النهائي لبرنامج آفاق إكسبرس'],

            ['title_en' => 'AFAC Field Visit to Libya', 'title_ar' => 'تقرير زيارة آفاق الميدانية الى ليبيا'],
            ['title_en' => 'AFAC Field Visit to Yemen', 'title_ar' => 'تقرير زيارة آفاق الميدانية الى اليمن'],

            ['title_en' => 'AFAC 2011 Annual report', 'title_ar' => 'تقرير آفاق السنوي للعام 2011'],

            ['title_en' => 'Tunisia cultural sector after the revolution - English', 'title_ar' => 'القطاع الثقافي في تونس بعد الثورة - إنكليزي'],
            ['title_en' => 'Tunisia cultural sector after the revolution - Arabic', 'title_ar' => 'القطاع الثقافي في تونس بعد الثورة - عربي'],

            ['title_en' => 'The First Four Years of AFAC', 'title_ar' => 'السنوات الأربعة الأولى'],

            ['title_en' => 'AFAC 2010 General Report', 'title_ar' => 'تقرير آفاق السنوي للعام 2010'],

            ['title_en' => 'What Is Art For?', 'title_ar' => 'لماذا الفن؟'],

            ['title_en' => 'AFAC Annual Report 2018 - English', 'title_ar' => 'تقرير آفاق السنوي 2018 - النسخة الإنكليزية'],

            ['title_en' => 'Audit Report 2018', 'title_ar' => 'التقرير المالي 2018'],

            ['title_en' => 'AFAC Annual Report 2019 - English', 'title_ar' => 'تقرير آفاق السنوي 2019- النسخة الإنكليزية'],
            ['title_en' => 'Audit Report 2019', 'title_ar' => 'التقرير المالي 2019'],

            ['title_en' => 'Audit Report 2020', 'title_ar' => 'التقرير المالي 2020'],

            ['title_en' => 'AFAC Annual Report 2020 - English', 'title_ar' => 'تقرير آفاق السنوي 2020 - النسخة الانكليزية'],

            ['title_en' => 'AFAC Annual Report 2021 - English', 'title_ar' => 'تقرير آفاق السنوي 2021 - النسخة الانكليزية'],

            ['title_en' => 'Audit Report 2021', 'title_ar' => 'التقرير المالي 2021'],

            ['title_en' => 'AFAC Annual Report 2022 - English', 'title_ar' => 'تقرير آفاق السنوي 2022- النسخة الانكليزية'],
            ['title_en' => 'AFAC Annual Report 2022 - Arabic', 'title_ar' => 'تقرير آفاق السنوي 2022- النسخة العربية'],

            ['title_en' => 'Audit Report 2022', 'title_ar' => 'التقرير المالي 2022'],

            ['title_en' => 'AFAC Annual Report 2023 - English', 'title_ar' => 'تقرير آفاق السنوي 2023- النسخة الانكليزية'],
            ['title_en' => 'AFAC Annual Report 2023 - Arabic', 'title_ar' => 'تقرير آفاق السنوي 2023- النسخة العربية'],

            ['title_en' => 'AFAC Annual Report 2024 - English', 'title_ar' => 'تقرير آفاق السنوي 2024 - النسخة الانكليزية'],
            ['title_en' => 'AFAC Annual Report 2024 - Arabic', 'title_ar' => 'تقرير آفاق السنوي 2024 - النسخة العربية'],

            ['title_en' => 'Audit Report 2023', 'title_ar' => 'التقرير المالي 2023'],
            ['title_en' => 'Audit Report 2024', 'title_ar' => 'التقرير المالي 2024'],

            ['title_en' => 'Supporting Material', 'title_ar' => 'المواد الداعمة'],

            ['title_en' => 'Harassment Prevention Bylaws', 'title_ar' => 'لائحة مناهضة التحرش'],
        ];

        foreach ($resources as $resource) {
            Entries::updateOrCreate(['type_id'=>'6','resource_title' => $resource["title_en"],'resource_title_arabic' => $resource["title_ar"] , 'published'=>'1']);
        }

    }
}
