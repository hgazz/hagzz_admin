<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Training::create([
            'name'=>fake()->name,
            'price'=> 100,
            'start_date'=>fake()->date,
            'end_date'=>fake()->date,
            'description'=>fake()->text,
            'coach_id'=>4,
            'academy_id'=>3,
            'max_players'=>10,
            'level'=>'Beginner',
            'gender'=>'All',
            'age_group'=>'All',
            'address_id'=>3,
            'sport_id'=>4,
            'discount_price'=>10,
        ]);
    }
}
