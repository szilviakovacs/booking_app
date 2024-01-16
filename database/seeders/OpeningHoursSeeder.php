<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OpeningHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        
        //2024-03-08-án 8-10 óra
        DB::table('opening_hours')->insert([
            'start_time' => Carbon::create(2024, 3, 8, 8, 0, 0),
            'end_time' => Carbon::create(2024, 3, 8, 10, 0, 0)->subMilliseconds(1),
            'recurrence' => 'none',
            'day_of_week' => null,
            'start_time_within_day' => null,
            'end_time_within_day' => null
        ]);

        //2024-01-01-től minden páros héten hétfőn 10-12 óra
        DB::table('opening_hours')->insert([
            'start_time' => Carbon::create(2024, 1, 1, 0, 0, 0),
            'end_time' => null,
            'recurrence' => 'even-weekly',
            'day_of_week' => 'monday',
            'start_time_within_day' => Carbon::parse('10:00:0')->format('H:i:s'),
            'end_time_within_day' => Carbon::parse('12:00:0')->subMilliseconds(1)->format('H:i:s')
        ]);

        
        //2024-01-01-től minden páratlan héten szerda 12-16 óra
        DB::table('opening_hours')->insert([
            'start_time' => Carbon::create(2024, 1, 1, 0, 0, 0),
            'end_time' => null,
            'recurrence' => 'odd-weekly',
            'day_of_week' => 'wednesday',
            'start_time_within_day' => Carbon::parse('12:00:00')->format('H:i:s'),
            'end_time_within_day' => Carbon::parse('16:00:0')->subMilliseconds(1)->format('H:i:s')
        ]);
        
        //2024-01-01-től minden héten pénteken 10-16 óra
        DB::table('opening_hours')->insert([
            'start_time' => Carbon::create(2024, 1, 1, 0, 0, 0),
            'end_time' => null,
            'recurrence' => 'weekly',
            'day_of_week' => 'friday',
            'start_time_within_day' => Carbon::parse('10:00:0')->format('H:i:s'),
            'end_time_within_day' => Carbon::parse('16:00:00')->subMilliseconds(1)->format('H:i:s')
        ]);

        
        //2024-06-01-től 2024-11-30-ig minden héten csütörtökön 16-20 óra
        DB::table('opening_hours')->insert([
            'start_time' => Carbon::create(2024, 6, 1, 0, 0, 0),
            'end_time' => Carbon::create(2024, 11, 30, 0, 0, 0)->subMilliseconds(1),
            'recurrence' => 'weekly',
            'day_of_week' => 'friday',
            'start_time_within_day' => Carbon::parse('10:00:00')->format('H:i:s'),
            'end_time_within_day' => Carbon::parse('16:00:00')->subMilliseconds(1)->format('H:i:s')
        ]);

    }
}
