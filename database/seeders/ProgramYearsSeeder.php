<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProgramYears;


class ProgramYearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $programYears = [

            1  => [2013,2015,2016,2017,2018,2019,2022],
            2  => [2018,2019,2020,2021],
            3  => range(2007, 2025),
            4  => [2007,2008,2009,2010,2011,2012,2013,2018,2019,2020,2021,2022,2023,2024,2025],
            5  => range(2007, 2025),
            6  => [2018,2019,2021,2022,2023,2024,2025],
            7  => [2014,2015,2016,2017,2018,2019,2020,2021,2022,2024,2025],
            8  => [2018,2019,2020,2022],
            9  => range(2007, 2025),
            10 => range(2007, 2025),
            11 => [2016,2017,2018,2019],
            12 => [2019],
            13 => [2020],
            14 => [2014,2015,2016],
            15 => [2008,2009,2010,2011,2012,2013,2014],
            16 => range(2007, 2017),
            17 => [2012,2014,2015],
            18 => [2011,2012],
            19 => [2009,2011,2012,2013,2014,2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025],
            21 => [2020],
            24 => [2023,2024],
            25 => [2024],
            26 => [2024,2025],
            27 => [2024],
            28 => [2024],
            30 => [2024],
        ];


        foreach ($programYears as $programId => $years) {
            foreach ($years as $year) {
                $data = [
                    'program_id' => $programId,
                    'year' => $year,
                ];
                ProgramYears::insert($data);
            }
        }

    }
}
