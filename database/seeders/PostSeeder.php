<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 30; $i++) {
            DB::table('posts')->insert([
                'title' => fake()->realText(25),
                'text' => fake()->realText(1000),
                'category_id' => Category::inRandomOrder()->first()->id,
            ]);
        }

    }
}
