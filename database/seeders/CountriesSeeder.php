<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Countries;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $countries = [
            ['name' => 'Afghanistan', 'name_arabic' => 'أفغانستان'],
            ['name' => 'Albania', 'name_arabic' => 'ألبانيا'],
            ['name' => 'Algeria', 'name_arabic' => 'الجزائر'],
            ['name' => 'Andorra', 'name_arabic' => 'أندورا'],
            ['name' => 'Angola', 'name_arabic' => 'أنغولا'],
            ['name' => 'Argentina', 'name_arabic' => 'الأرجنتين'],
            ['name' => 'Armenia', 'name_arabic' => 'أرمينيا'],
            ['name' => 'Australia', 'name_arabic' => 'أستراليا'],
            ['name' => 'Austria', 'name_arabic' => 'النمسا'],
            ['name' => 'Azerbaijan', 'name_arabic' => 'أذربيجان'],
            ['name' => 'Bahrain', 'name_arabic' => 'البحرين'],
            ['name' => 'Bangladesh', 'name_arabic' => 'بنغلاديش'],
            ['name' => 'Belgium', 'name_arabic' => 'بلجيكا'],
            ['name' => 'Brazil', 'name_arabic' => 'البرازيل'],
            ['name' => 'Canada', 'name_arabic' => 'كندا'],
            ['name' => 'China', 'name_arabic' => 'الصين'],
            ['name' => 'Egypt', 'name_arabic' => 'مصر'],
            ['name' => 'France', 'name_arabic' => 'فرنسا'],
            ['name' => 'Germany', 'name_arabic' => 'ألمانيا'],
            ['name' => 'India', 'name_arabic' => 'الهند'],
            ['name' => 'Indonesia', 'name_arabic' => 'إندونيسيا'],
            ['name' => 'Iraq', 'name_arabic' => 'العراق'],
            ['name' => 'Italy', 'name_arabic' => 'إيطاليا'],
            ['name' => 'Japan', 'name_arabic' => 'اليابان'],
            ['name' => 'Jordan', 'name_arabic' => 'الأردن'],
            ['name' => 'Kuwait', 'name_arabic' => 'الكويت'],
            ['name' => 'Lebanon', 'name_arabic' => 'لبنان'],
            ['name' => 'Libya', 'name_arabic' => 'ليبيا'],
            ['name' => 'Morocco', 'name_arabic' => 'المغرب'],
            ['name' => 'Oman', 'name_arabic' => 'عمان'],
            ['name' => 'Palestine', 'name_arabic' => 'فلسطين'],
            ['name' => 'Qatar', 'name_arabic' => 'قطر'],
            ['name' => 'Saudi Arabia', 'name_arabic' => 'المملكة العربية السعودية'],
            ['name' => 'Somalia', 'name_arabic' => 'الصومال'],
            ['name' => 'Sudan', 'name_arabic' => 'السودان'],
            ['name' => 'Syria', 'name_arabic' => 'سوريا'],
            ['name' => 'Tunisia', 'name_arabic' => 'تونس'],
            ['name' => 'Turkey', 'name_arabic' => 'تركيا'],
            ['name' => 'United Arab Emirates', 'name_arabic' => 'الإمارات العربية المتحدة'],
            ['name' => 'United Kingdom', 'name_arabic' => 'المملكة المتحدة'],
            ['name' => 'United States', 'name_arabic' => 'الولايات المتحدة الأمريكية'],
            ['name' => 'Yemen', 'name_arabic' => 'اليمن'],
        ];

        foreach ($countries as $country) {
            Countries::updateOrCreate(['name' => $country["name"],'name_arabic' => $country["name_arabic"]]);
        }
    }
}
