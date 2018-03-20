<?php

use Illuminate\Database\Seeder;

class Article_categoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('article_category')->insert(['category' => 1,
            'description' => 'travel',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 0]);
        DB::table('article_category')->insert(['category' => 2,
            'description' => 'reading',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 0]);
        DB::table('article_category')->insert(['category' => 3,
            'description' => 'sports',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 0]);
        DB::table('article_category')->insert(['category' => 4,
            'description' => 'games',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 0]);
        DB::table('article_category')->insert(['category' => 5,
            'description' => 'question',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 0]);
        DB::table('article_category')->insert(['category' => 6,
            'description' => 'market',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 0]);
        DB::table('article_category')->insert(['category' => 7,
            'description' => 'appointment',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 0]);
        DB::table('article_category')->insert(['category' => 8,
            'description' => 'appointmentMan',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 7]);
        DB::table('article_category')->insert(['category' => 9,
            'description' => 'appointmentFemale',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 7]);
        DB::table('article_category')->insert(['category' => 10,
            'description' => 'appointmentFemale',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'pCategory_id' => 0]);
    }
}
