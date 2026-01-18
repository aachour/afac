<?php

namespace Database\Seeders;

use App\Models\Entries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $programs = [
            ['title_en' => 'Documentary Film', 'title_ar' => 'الأفلام الوثائقية'],
            ['title_en' => 'Research on the Arts Program', 'title_ar' => 'برنامج البحوث حول الفنون'],
            ['title_en' => 'Cinema', 'title_ar' => 'السينما'],
            ['title_en' => 'Creative and Critical Writings', 'title_ar' => 'الكتابات الإبداعية والنقدية'],
            ['title_en' => 'Music', 'title_ar' => 'الموسيقى'],
            ['title_en' => 'Training and Regional Events', 'title_ar' => 'التدريب والنشاطات الإقليمية'],
            ['title_en' => 'The Arab Documentary Photography Program', 'title_ar' => 'برنامج التصوير الفوتوغرافي الوثائقي العربي'],
            ['title_en' => 'Arts and Culture Entrepreneurship', 'title_ar' => 'الريادة في الفنون والثقافة'],
            ['title_en' => 'Visual Arts', 'title_ar' => 'الفنون البصرية'],
            ['title_en' => 'Performing Arts', 'title_ar' => 'الفنون الأدائية'],
            ['title_en' => 'Arab European Creative Platform', 'title_ar' => 'المنتدى العربي الأوروبي الإبداعي'],
            ['title_en' => 'North Africa Cultural Program (NACP) - NATIONAL FUND', 'title_ar' => 'برنامج شمال إفريقيا الثقافي - منحة الدعم المحلّي'],
            ['title_en' => 'North Africa Cultural Program (NACP) - REGIONAL FUND', 'title_ar' => 'برنامج شمال إفريقيا الثقافي - منحة الدعم الإقليمي'],
            ['title_en' => 'The AFAC Novel Writing Program', 'title_ar' => 'برنامج آفاق لكتابة الرواية'],
            ['title_en' => 'Literature', 'title_ar' => 'الأدب'],
            ['title_en' => 'Research/Training/Regional Events', 'title_ar' => 'البحوث/التدريب/النشاطات الإقليمية'],
            ['title_en' => 'Crossroads', 'title_ar' => 'تقاطعات'],
            ['title_en' => 'AFAC Express', 'title_ar' => 'آفاق أكسبرس'],
            ['title_en' => 'Arab Documentary Film Program', 'title_ar' => 'برنامج الفيلم الوثائقي العربي'],
            ['title_en' => 'Solidarity Fund for Arts and Culture Structures in Lebanon', 'title_ar' => 'صندوق التضامن لدعم المؤسسات الفنية والثقافية في لبنان'],
            ['title_en' => 'Artist Support Grant', 'title_ar' => 'منحة دعم الفنّانين'],
            ['title_en' => 'Lebanon Solidarity Fund', 'title_ar' => 'صندوق التضامن مع لبنان'],
            ['title_en' => 'The AFAC-Netflix Hardship Fund', 'title_ar' => 'برنامج آفاق - Netflix لدعم العاملات والعاملين'],
            ['title_en' => 'Writers Room', 'title_ar' => 'غرفة الكُتّاب'],
            ['title_en' => 'AFAC X NETFLIX | Women in Film', 'title_ar' => 'آفاق X صندوق نتفليكس لدعم المواهب الإبداعية'],
            ['title_en' => 'Arab Documentary Photography Program Alumni Fellowship', 'title_ar' => 'زمالة خريجي برنامج التصوير الفوتوغرافي الوثائقي العربي'],
            ['title_en' => 'National Cultural Opportunities Fund (NCOF)', 'title_ar' => 'صندوق الدعم المحلي'],
            ['title_en' => 'Regional Competitive Creativity Fund (RCCF)', 'title_ar' => 'صندوق الدعم الإقليمي'],
            ['title_en' => 'The North Africa Cultural Program | Cycle II', 'title_ar' => 'برنامج شمال إفريقيا الثقافي | الدورة الثانية'],
            ['title_en' => 'The Cultural Atelier in Yemen', 'title_ar' => 'برنامج الورشة الثقافية في اليمن'],
            ['title_en' => 'AFAC x Netflix Women in Film – Bring Your Story', 'title_ar' => 'مختبر الفيلم القصير لصانعات أفلام صاعدات'],
            ['title_en' => 'Ecologies of Culture', 'title_ar' => 'بيئات الثقافة'],
            ['title_en' => 'Ecologies of Culture | Creative Placemaking', 'title_ar' => 'بيئات الثقافة | تشكيل فضاءات إبداعية'],
            ['title_en' => 'Ecologies of Culture | Creative Labs', 'title_ar' => 'بيئات الثقافة | مختبرات إبداعية'],
            ['title_en' => 'Ecologies of Culture | Creative Caravans', 'title_ar' => 'بيئات الثقافة | قوافل إبداعية'],
        ];

        foreach ($programs as $program) {
            Entries::updateOrCreate(['type_id'=>'2','program_title' => $program['title_en'],'program_title_arabic' => $program['title_ar'] , 'published'=>'1' ]);
        }

    }
}
