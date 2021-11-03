<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->truncate();

        $faker = Faker::create('ru_RU');

        DB::table('employees')->insert([
            'level' => 0,
            'surname' => $faker->lastName('male'),
            'name' => $faker->firstName('male'),
            'patronymic' => $faker->middleName('male'),
            'position' => 'Руководитель предприятия',
            'recruitment_date' => Carbon::create('2010', '01', '01'),
            'salary' => 5000
        ]);
        
        for ($empLevel = 1; $empLevel <= 5; $empLevel++){
            $parentLevel = $empLevel - 1;
            for ($empNum = 1; $empNum <= 10; $empNum++){
                $empPosition = match($empLevel){
                    1 => 'Руководитель отдела '. $empNum,
                    2 => 'Руководитель цеха '. $empNum,
                    3 => 'Руководитель участка '. $empNum,
                    4 => 'Руководитель группы '. $empNum,
                    5 => 'Инженер'
                };
                $EmpParentID = DB::table('employees')->where('level', $parentLevel)->inRandomOrder()->first()->id;
                DB::table('employees')->insert([
                     'employee_id' => $EmpParentID,
                     'level' => $empLevel,
                     'surname' => $faker->lastName('male'),
                     'name' => $faker->firstName('male'),
                     'patronymic' => $faker->middleName('male'),
                     'position' =>  $empPosition,
                     'recruitment_date' => Carbon::today()->subDays(rand(1, 365)),
                     'salary' => rand(2000, 4000)
                 ]);    
            }

        }
    }
}
