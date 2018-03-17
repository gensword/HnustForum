<?php

use Illuminate\Database\Seeder;

class Artickle_statusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('article_status')->insert(['status' => 0,
            'description' => 'sink',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);
        DB::table('article_status')->insert(['status' => 1,
            'description' => 'normal',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);
        DB::table('article_status')->insert(['status' => 2,
            'description' => 'stick',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);
        DB::table('article_status')->insert(['status' => 4,
            'description' => 'digest',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);
        DB::table('article_status')->insert(['status' => 6,
            'description' => 'stick digest',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);
    }
}
